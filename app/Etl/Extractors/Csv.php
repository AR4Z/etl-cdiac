<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use App\Etl\Extractors\ExtractType\ExtractTypeInterface;
use App\Etl\Steps\{StepList,Step,StepContract};
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

class Csv extends ExtractorBase implements ExtractorInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Csv';

    /**
     * @var string
     */
    public $extension = 'csv';

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @var string
     */
    public $fileName = null;

    /**
     * @var ExtractTypeInterface
     */
    public $extractTypeObject = null;

    /**
     * @var string
     */
    public $extractType = null;

    /**
     * @var bool
     */
    public $truncateTemporal = true;

    /**
     * @var bool
     */
    public $flagStationSk = false;

    /**
     * @var bool
     */
    public $flagDateSk = false;

    /**
     * @var bool
     */
    public $flagTimeSk = false;

    /**
     * @var bool
     */
    public $dateTime = false;

    /**
     * @return $this|mixed
     */
    public function run()
    {
        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());

        # Se ejecutan los pasos que se requieren para el proceso
        $this->stepsList->runStartList($this->etlConfig->processState,$this);
    }

    /**
     * Es muy importante el orden de los pasos
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList): StepList
    {
        $stepList->addStep( new Step('stepConfigureSpaceWork'));
        $stepList->addStep( new Step('stepConfigureConsults'));
        $stepList->addStep( new Step('stepLoadFile'));
        $stepList->addStep( new Step('stepCalculateDateTime'));
        $stepList->addStep( new Step('stepDeleteUnwantedFieldsKeys'));
        $stepList->addStep( new Step('stepDeleteExpectedErrorsKeys'));
        $stepList->addStep( new Step('stepUpdateKeys'));
        $stepList->addStep( new Step('stepTrustProcess'));

        return $stepList;
    }

    /**############################################ STEP SECTION ################################################### **/

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

            ($this->etlConfig->keys)->config(
                $this->etlConfig->typeProcess,
                ($this->etlConfig->station)->typeStation->etl_method,
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

            if ($this->dateTime){ $this->getCalculateDateAndTime(); }

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

            $this->deleteTimeAndDateNull();

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

            $this->deleteLastDateWDT($this->etlConfig->repositorySpaceWork,'24:00:00');
            $this->deleteLastDateWDT($this->etlConfig->repositorySpaceWork,'00:00:00');

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
            if (!$this->flagStationSk){$this->flagStationSk =  $this->updateStationSk($this->etlConfig->station->id);}

            if (!$this->flagDateSk){$this->flagDateSk = $this->updateDateSk();}

            if (!$this->flagTimeSk){$this->flagTimeSk = $this->updateTimeSk();}

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

    /**######################################## END STEP SECTION ################################################### **/


    /**########################################## SETTERS SECTION ################################################### **/

    /**
     * @param string $extension
     */
    public function setExtension(string $extension = 'csv')
    {
        $this->extension = $extension;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param bool $flagDateSk
     */
    public function setFlagDateSk(bool $flagDateSk = false)
    {
        $this->flagDateSk = $flagDateSk;
    }

    /**
     * @param bool $flagTimeSk
     */
    public function setFlagTimeSk(bool $flagTimeSk = false)
    {
        $this->flagTimeSk = $flagTimeSk;
    }

    /**
     * @param bool $dateTime
     */
    public function setDateTime(bool $dateTime = false)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @param array $inputVariables # TODO ESTE METODO HAY QUE QUITARLO ?? O CREAR OTRA PROPIEDAD
     */
    private function setDateTimeProperty(array $inputVariables)
    {
        $this->dateTime = in_array('date_time',$inputVariables);
    }

    /**####################################### END SETTERS SECTION ################################################## **/


    /**######################################### PRIVATE SECTION ################################################### **/

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
        $configCsv = (object)Config::get('etl')['csv_keys'][$this->etlConfig->station->typeStation->etl_method];
        foreach ($configCsv as $key => $value){
            if (in_array($value['incoming_name'],$inputVariables)){$arr[$value['incoming_name']] = $value['local_name'];}
        }
        foreach ($this->etlConfig->varForFilter as $value)
        {
            if (in_array($value->excel_name,$inputVariables)){
                $arr[$value->excel_name] = $value->local_name ;
            }
        }
        return $arr;
    }

    /**
     *
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    private function configureDateTimes()
    {
        $initVal = $this->getInitialDataInSpaceWorkWDT($this->etlConfig->repositorySpaceWork);
        $finalVal = $this->getFinalDataInSpaceWorkWDT($this->etlConfig->repositorySpaceWork);

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
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    private function changeCommaForPointAllVariables() : bool
    {
        # Extraer variables para el proceso
        $varFilter = $this->etlConfig->varForFilter;

        #Cambiar comas por puntos en los decimales.
        foreach ($varFilter as $value) { $this->changeCommaForPointWDT($this->etlConfig->repositorySpaceWork,$value->local_name);}

        return true;
    }

    /**
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    protected function csv()
    {
        Excel::load(storage_path().'/app/public/'.$this->fileName, function(LaravelExcelReader $reader) {

            $inputVariables = $reader->all()->getHeading();
            $variablesName = $this->getVariablesName($inputVariables);
            $variablesNameExcel = array_keys($variablesName);

            #dd($reader,$inputVariables,$variablesName,$variablesNameExcel);

            # Se edita la propiedad data time TODO porque se entrega esta variable a el date time ?? esta variables es bool
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    protected function txt()
    {
        # Se lee el archivo
        $file = file(storage_path().'/app/public/'. $this->fileName,FILE_IGNORE_NEW_LINES);

        # Extraer los encabezados del archivo text delimitado por comas
        $inputVariables = explode(",",$file[0]);

        # Se eliminan los encabezados el array del archivo
        unset($file[0]);

        # Se cargan las variables dependiendo de las variables cargadas
        $variablesName = $this->getVariablesName($inputVariables);

        # Se edita la propiedad data time TODO porque se entrega esta variable a el date time ?? esta variables es bool
        # $this->setDateTimeProperty($inputVariables);

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
        $this->insertDataArrayWDT($this->etlConfig->repositorySpaceWork,$data);

        return true;
    }

    /**####################################### END PRIVATE SECTION ################################################# **/
}
