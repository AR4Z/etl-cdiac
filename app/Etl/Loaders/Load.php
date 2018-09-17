<?php


namespace App\Etl\Loaders;

use App\Etl\EtlConfig;
use function Couchbase\defaultDecoder;

class Load extends LoadBase implements LoadInterface
{
    private $method = 'General';

    public  $etlConfig = null;

    public $select = '';

    public  $columns = [];

    public $deleteDuplicates = true;

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        return $this;
    }

    /**
     * @return $this
     */
    public function run()
    {
        # Extraer las configuraciones de llaves perimarias
        $this->select = $this->etlConfig->getKeys()->loadCastKey;

        # Extraer las columnas que se deben ingrear que no estan el base de datos (keys and comment and etc)
        $this->columns = $this->etlConfig->getKeys()->load;

        # Configuración de la consulta para extraer los datos de temporal_work
        $this->setSelect('local_name','local_name');

        # Direccionar los datos existentes a la tabla de existentes
        $this->redirectExisting();

        # Eliminar los duplicados
        $this->deleteDuplicates();

        if ($this->etlConfig->isCalculateDateTime())
        {
            # Se calcula la fechas cuando son null
            $this->completeDateNull();

            # Se calcula la hora cuando es null
            $this->completeTimeNull();

            # Se calcula el date_time
            $this->InsertDateTime();
        }

        # Extraer valores de la tabla temporal
        $values = $this->selectTemporalTable();

        if (!empty($values)){
            #Insertar datos en en su respectiva fact
            $this->insertAllDataInFact($values);
        }

        # Calcular la confienza y el soporte
        $this->trustProcess();

        # Migrar los datos de correccion a historial de correccion
        if ($this->etlConfig->getTypeProcess() != "Original"){
            $this->migrateHistoricCorrection();
        }

        # Actualizar las fechas y horas del migrado
        $this->calculateSequence();

        return $this;
    }

    /**
     * @param $colOrigin
     * @param $colDestination
     * @return $this
     */
    public function setSelect($colOrigin, $colDestination)
    {
        $variables= $this->etlConfig->getVarForFilter();
        $temporalSelect = '';

        if ($this->etlConfig->getTypeProcess() !== "Original"){
            foreach ($variables as $variable){
                $temporalSelect .= 'CAST('.$variable->$colOrigin.' AS float) AS '. $variable->$colDestination.', ';
                array_push($this->columns,$variable->$colDestination);
            }
        }else{
            foreach ($variables as $variable){
                $temporalSelect .= $variable->$colOrigin.' AS '. $variable->$colDestination.', ';
                array_push($this->columns,$variable->$colDestination);
            }
        }

        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }

    /**
     * @return mixed
     */
    public function selectTemporalTable()
    {
        return $this->getAllData('temporary_work',$this->etlConfig->getTableSpaceWork(),$this->select);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function insertAllDataInFact($data)
    {
       return $this->insertDataEncode('data_warehouse',$this->etlConfig->getTableDestination(),$data);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     *
     */
    public function InsertDateTime()
    {
        $val = $this->getIdAndDateTime($this->etlConfig->getTableSpaceWork());

        foreach ($val as $item)
        {
            $this->updateDateTimeFromId(
                $this->etlConfig->getTableSpaceWork(),
                $item->id,
                [ 'date_time'=> $item->date.''. (is_null($item->time) ? '' : ' '.$item->time ) ]
            );
        }
    }

    public function completeDateNull()
    {
        $datesNull = $this->selectColumnWhereNull(    $this->etlConfig->getTableSpaceWork(),'date_sk','date');

        foreach ($datesNull as $dates) {
            $this->updateDateFromDateSk(
                $this->etlConfig->getTableSpaceWork(),
                $dates->date_sk,
                $this->calculateDateFromDateSk($dates->date_sk)
            );
        }
    }

    public function completeTimeNull()
    {
        $timesNull = $this->selectColumnWhereNull(    $this->etlConfig->getTableSpaceWork(),'time_sk','time');

        foreach ($timesNull as $time) {
            if($time->time_sk < $this->maxValueSk){
                $this->updateTimeFromTimeSk(
                    $this->etlConfig->getTableSpaceWork(),
                    $time->time_sk,
                    $this->calculateTimeFromTimeSk($time->time_sk)
                );
            }
        }
    }

    /**
     * Se el ultimo dato entrante cuando se ingresan datos duplicados
     */
    public function deleteDuplicates()
    {
        if ($this->deleteDuplicates) {

            # se extrae el maximo id cuando existen datos duplicados
            $result = $this->getDuplicates($this->etlConfig->getTableSpaceWork());

            # se eliminan los id's duplicados
            if (count($result) > 0){ $this->deleteWhereInVariable($this->etlConfig->getTableSpaceWork(),'id', array_column($result,'max')); }
        }
    }


}