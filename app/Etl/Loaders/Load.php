<?php


namespace App\Etl\Loaders;


use App\Etl\EtlConfig;
use App\Etl\Traits\WorkDatabaseTrait;



class Load extends LoadBase implements LoadInterface
{
    use WorkDatabaseTrait;

    private $method = 'General';

    private  $etlConfig = null;

    private $select = '';

    private  $columns = [];

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
        $this->select = $this->etlConfig->getKeys()->globalCastKey;
        $this->columns = $this->etlConfig->getKeys()->global;

        //Configuración de la consulta para extraer los datos de temporal_work
        $this->setSelect(
            $this->etlConfig->getVarForFilter(),
            'local_name',
            'local_name'
        );
        //Direccionar los datos existentes a la tabla de existentes
        $this->redirectExisting(
                    $this->etlConfig->getRepositorySpaceWork(),
                    $this->etlConfig->getRepositoryDestination(),
                    $this->etlConfig->getRepositoryExist(),
                    $this->etlConfig->getTableExist()
                );

        //Insertar datos en en su respectiva fact
        $this->insertAllDataInFact($this->selectTemporalTable());

        // Actualizar las fechas y horas del migrado
        $this->calculateSequence(
            $this->etlConfig->geTtableSpaceWork(),
            $this->etlConfig->getSequence(),
            $this->etlConfig->getFinalDate(),
            $this->etlConfig->getStation()->{$this->etlConfig->getStateTable()}
        );

        return $this;
    }

    /**
     * @param $variables
     * @param $colOrigin
     * @param $colDestination
     * @return $this
     */
    public function setSelect($variables, $colOrigin, $colDestination)
    {
        $temporalSelect = '';
        foreach ($variables as $variable){
            $temporalSelect .= 'CAST('.$variable->$colOrigin.' AS float) AS '. $variable->$colDestination.', ';
            array_push($this->columns,$variable->$colDestination);
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


}