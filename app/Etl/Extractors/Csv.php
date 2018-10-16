<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use App\Etl\Steps\Step;
use App\Etl\Steps\StepContract;
use App\Etl\Steps\StepList;
use function Couchbase\defaultDecoder;
use Exception;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;


class Csv extends ExtractorBase implements ExtractorInterface, StepContract
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

        return $this;
    }

    /**
     * Es muy importante el orden de los pasos
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList): StepList
    {
        $controlState = $this->etlConfig->processState;

        $stepList->addStep( new Step($controlState,'stepConfigureSpaceWork'));
        $stepList->addStep( new Step($controlState,'stepConfigureConsults'));
        $stepList->addStep( new Step($controlState,'stepLoadFile'));
        $stepList->addStep( new Step($controlState,'stepCalculateDateTime'));
        $stepList->addStep( new Step($controlState,'stepDeleteUnwantedFieldsKeys'));
        $stepList->addStep( new Step($controlState,'stepDeleteExpectedErrorsKeys'));
        $stepList->addStep( new Step($controlState,'stepUpdateKeys'));
        $stepList->addStep( new Step($controlState,'stepTrustProcess'));

        return $stepList;
    }

    /**
     * STEP
     * Truncar la tabla de trabajo
     * @return array
     */
    public function stepConfigureSpaceWork() : array
    {
        try {
            if ($this->truncateTemporal){ $this->configureSpaceWork(); }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Configurar las consultas para la extraccion de los datos
     * @return array
     */
    public function stepConfigureConsults() : array
    {
        try {

            ($this->etlConfig->getKeys())->config(
                $this->etlConfig->getTypeProcess(),
                $this->etlConfig->getStation()->typeStation->etl_method,
                'Plane',
                null
            );

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Leer e insertar datos en base de datos
     * @return array
     */
    public function stepLoadFile() : array
    {
        try {

            $this->loadFile();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Calcular la fecha y la hora dependiendo de un DateTime
     * @return array
     */
    public function stepCalculateDateTime() : array
    {
        try {

            if ($this->dateTime){ $this->getCalculateDateAndTime($this->etlConfig->getTableSpaceWork()); }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Eliminar campos no deseados en las llaves primarias
     * @return array
     */
    public function stepDeleteUnwantedFieldsKeys() : array
    {
        try {

            $this->deleteTimeAndDateNull($this->etlConfig->getTableSpaceWork());

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Eliminar Ultimo dato el cual es erroneo por definicion
     * @return array
     */
    public function stepDeleteExpectedErrorsKeys() : array
    {
        try {

            $this->deleteLastDate($this->etlConfig->getTableSpaceWork(),'24:00:00');
            $this->deleteLastDate($this->etlConfig->getTableSpaceWork(),'00:00:00');

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Ingresar la llave subrrogada de la estacion
     * Ingresar la llave subrrogada de la fecha
     * Ingresar la llave subrrogada de la tiempo
     * Editar las fechas y horas iniciales y finales dependiendo de los registros engresados por archivo plano
     * @return array
     */
    public function stepUpdateKeys() : array
    {
        try {
            if (!$this->flagStationSk){$this->updateStationSk($this->etlConfig->getStation()->id);}

            if (!$this->flagDateSk){$this->updateDateSk();}

            if (!$this->flagTimeSk){$this->updateTimeSk();}

            $this->configureDateTimes();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * @return array
     */
    public function stepTrustProcess() : array
    {
        try {

            $this->trustProcess();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
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
