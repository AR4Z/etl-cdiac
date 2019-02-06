<?php

namespace App\Etl\Extractors;

use App\Etl\Extractors\ExtensionLoad\ExtensionLoadContract;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class Plane extends ExtractorBase implements ExtractorInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Plane';

    /**
     * @var ExtensionLoadContract
     */
    public $extension = null;

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @var string
     */
    public $fileName = null;

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
            $this->etlConfig->keys->config(
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
            if ($this->extension->isDateTime()){ $this->getCalculateDateAndTime(); }

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
        $this->extension = $this->factoryExtractorClass('ExtensionLoad',$extension);
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

    /**####################################### END SETTERS SECTION ################################################## **/


    /**######################################### PRIVATE SECTION ################################################### **/

    /**
     *
     */
    private function loadFile()
    {
        if (is_null($this->extension)){$this->setExtension();}

        $this->extension->loadFormatData(
            $this->etlConfig->repositorySpaceWork,
            $this->etlConfig->station->typeStation->etl_method,
            $this->etlConfig->varForFilter,
            $this->fileName
        );

    }

    /**
     *
     */
    private function configureDateTimes()
    {
        $initVal = $this->etlConfig->repositorySpaceWork->getInitialData();
        $finalVal = $this->etlConfig->repositorySpaceWork->getFinalData();

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

    /**####################################### END PRIVATE SECTION ################################################# **/
}
