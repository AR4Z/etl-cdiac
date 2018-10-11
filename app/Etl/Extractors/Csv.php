<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use function Couchbase\defaultDecoder;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;


class Csv extends ExtractorBase implements ExtractorInterface
{

    private $method = 'Csv';

    public $extension = 'csv';

    public $etlConfig = null;

    public $fileName = null;

    public $extractTypeObject = null;

    public $extractType = null;

    public $truncateTemporal = true;

    public $flagStationSk = false;

    public $flagDateSk = false;

    public $flagTimeSk = false;

    public $dateTime = false;

    /**
     * Csv constructor.
     * @param $etlConfig
     * @return $this|mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return $this|mixed
     */
    public function run()
    {
        # Configurar las consultas para la extraccion de los datos
        ($this->etlConfig->getKeys())->config(
            $this->etlConfig->getTypeProcess(),
            $this->etlConfig->getStation()->typeStation->etl_method,
            'Plane',
            null
        );


        if ($this->truncateTemporal){
            # Truncar la tabla de trabajo
            $this->configureSpaceWork();

            #Leer e insertar datos en base de datos
            $this->loadFile();
        }

        if ($this->dateTime){
            # Calcular la fecha y la hora dependiendo de un DateTime
            $this->getCalculateDateAndTime($this->etlConfig->getTableSpaceWork());
        }

        # Eliminar cambos no deseados en las llaves primarias
        $this->deleteTimeAndDateNull($this->etlConfig->getTableSpaceWork());

        # Eliminar Ultimo dato el cual es erroneo por definicion
        $this->deleteLastDate($this->etlConfig->getTableSpaceWork(),'24:00:00');
        $this->deleteLastDate($this->etlConfig->getTableSpaceWork(),'00:00:00');

        # Ingresar la llave subrrogada de la estacion
        if (!$this->flagStationSk){$this->updateStationSk($this->etlConfig->getStation()->id);}

        # Ingresar la llave subrrogada de la fecha
        if (!$this->flagDateSk){$this->updateDateSk();}

        # Ingresar la llave subrrogada de la tiempo
        if (!$this->flagTimeSk){$this->updateTimeSk();}

        # Editar las fechas y horas iniciales y finales dependiendo de los registros engresados por archivo plano
        $this->configureDateTimes();

        # Ejecutar el proceso de confianza y soporte de los datos
        $trustProcess = $this->trustProcess();

        return $this;
    }

    /**
     *
     */
    private function loadFile()
    {
        if (!method_exists($this,$this->extension)){ return false;}
        return $this->{$this->extension}();
    }

    /**
     * @param $inputVariables
     * @return array
     */
    private function getVariablesName($inputVariables)
    {
        $arr = [];
        $configCsv = (object)Config::get('etl')['csv_keys'][$this->etlConfig->getStation()->typeStation->etl_method];
        foreach ($configCsv as $key => $value){
            if (in_array($value['incoming_name'],$inputVariables)){$arr[$value['incoming_name']] = $value['local_name'];}
        }
        foreach ($this->etlConfig->getVarForFilter() as $value)
        {
            if (in_array($value->excel_name,$inputVariables)){
                $arr[$value->excel_name] = $value->local_name ;
            }
        }
        return $arr;
    }

    /**
     *
     */
    private function configureDateTimes()
    {
        $initVal = $this->getInitialDataInSpaceWork();
        $finalVal = $this->getFinalDataInSpaceWork();

        if (!is_null($initVal)){
            $this->etlConfig->setInitialDate(
                $this->calculateDateFromDateSk($initVal->date_sk)
            );
            $this->etlConfig->setInitialTime(
                $this->calculateTimeFromTimeSk($initVal->time_sk)
            );
        }
        if (!is_null($finalVal)){
            $this->etlConfig->setFinalDate(
                $this->calculateDateFromDateSk($finalVal->date_sk)
            );
            $this->etlConfig->setFinalTime(
                $this->calculateTimeFromTimeSk($finalVal->time_sk)
            );
        }
    }

    /**
     * @param array $inputVariables
     */
    private function setDateTimeProperty(array $inputVariables)
    {
        $this->dateTime = in_array('date_time',$inputVariables);
    }

    /**
     * @return bool
     */
    private function csv()
    {
        Excel::load(storage_path().'/app/public/'.$this->fileName, function($reader) {

            $inputVariables = $reader->all()->getHeading();
            $variablesName = $this->getVariablesName($inputVariables);
            $variablesNameExcel = array_keys($variablesName);

            $this->setDateTimeProperty($inputVariables);

            foreach ($reader->get() as $values){
                $val = [];
                $values->toArray();
                foreach ($inputVariables as $inputVariable){
                    if (in_array($inputVariable,$variablesNameExcel)){
                        $val[$variablesName[$inputVariable]] = $values[$inputVariable];
                    }
                }
                $this->etlConfig->repositorySpaceWork->create($val);
            }
        });
        # cambiar de comas a puntos los datos de las variables
        $this->changeCommaForPointAllVariables();

        return true;
    }

    /**
     * @return bool
     */
    private function txt()
    {
        # Se lee el archivo
        $file = file(storage_path().'/app/public/'. $this->fileName,FILE_IGNORE_NEW_LINES);

        # Extraer los encabezados del archivo text delimitado por comas
        $inputVariables = explode(",",$file[0]);

        # Se eliminan los encabezados el array del archivo
        unset($file[0]);

        # Se cargan las variables dependiendo de las variables cargadas
        $variablesName = $this->getVariablesName($inputVariables);

        # Se edita la propiedad data time
        $this->setDateTimeProperty($inputVariables);

        # Se buscan los encabezados entrantes y se obtiene el nombre en la tabla temporal
        $headers = [];
        foreach ($inputVariables as $inputVariable){
            if (array_key_exists($inputVariable,$variablesName)){
                array_push($headers,$variablesName[$inputVariable]);
            }
        }

        # Se genera el array para insertar en la tabla temporal
        $data = [];
        foreach ($file as $row) {
            array_push($data,array_combine($headers,explode(",",$row)));
        }

        # Se inserta el array en a tabla temporal
        $this->insertDataArray($this->etlConfig->getTableSpaceWork(),$data);

        return true;
    }

    public function changeCommaForPointAllVariables()
    {
        #Cambiar comas por puntos en los decimales.
        $varFilter = $this->etlConfig->getVarForFilter();
        foreach ($varFilter as $value) {
            $this->changeCommaForPoint($this->etlConfig->getTableSpaceWork(), $value->local_name);
        }

        return true;
    }
}
