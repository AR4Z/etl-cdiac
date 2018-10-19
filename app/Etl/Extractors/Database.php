<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use App\Etl\Extractors\ExtractType\External;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class Database extends ExtractorBase implements ExtractorInterface, StepContract
{
  /**
   * $method is the data type incoming
   * @var string
   */
    public $method = 'Database';

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @var EtlConfig
     */
    public $etlConfig = null;

    /**
     * @var External or Local
     */
    public $extractTypeObject = null;

    /**
     * @var string
     */
    public $extractType = null;

    /**
     * @var bool
     */
    public  $truncateTemporal = true;

    /**
     * @param $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());
    }

    /**
     * Punto de acceso para ejecutar funcionalidad
     */
    public function run()
    {
        # Se ejecutan los pasos que se requieren para el proceso
        $this->stepsList->runStartList($this->etlConfig->processState,$this);
    }

    /**
     * EL ORDEN DE LOS PASOS ES MUY IMPORTANTE
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList) : StepList
    {
        $stepList->addStep( new Step('configureSpaceWork'));
        $stepList->addStep( new Step('stepCreateExtractType'));
        $stepList->addStep( new Step('stepConfigureConsults'));
        $stepList->addStep( new Step('stepIncludeDataInSpaceWork'));
        $stepList->addStep( new Step('stepUpdateKeys'));
        $stepList->addStep( new Step('stepTrustProcess'));

        return $stepList;
    }

    /**
     * STEP
     * Crear el objeto de extraccion /ExtracType (este posee configuraciones diferentes para local y externa)
     * @return array
     */
    public function stepConfigureConsults() : array
    {
        try {
            $this->extractTypeObject = $this->createExtractType($this->extractType,$this->etlConfig);

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }
    /**
     * STEP
     * Configurar las consultas para la extraccion de los datos
     * Se usa la clase keys disponible en EtlConfig
     * @return array
     */
    public function stepCreateExtractType() : array
    {
        try {
            ($this->etlConfig->getKeys())->config(
                $this->etlConfig->getTypeProcess(),
                ($this->etlConfig->getStation())->typeStation->etl_method,
                $this->method,
                $this->extractType
            );

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }
    /**
     * STEP
     * Extraer los datos de la central de acopio e insertar datos en el espacio de trabajo
     * @return array
     */
    public function stepIncludeDataInSpaceWork() : array
    {
        try {
            $this->insertAllDataInTemporal(
                ($this->extractTypeObject)->extractData(
                    $this->etlConfig->getkeys(),
                    $this->etlConfig->getInitialDate(),
                    $this->etlConfig->getInitialTime(),
                    $this->etlConfig->getFinalDate(),
                    $this->etlConfig->getFinalTime(),
                    10000
                )
            );

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * * Ingresar la llave subrrogada de la estacion
     * * Ingresar la llave subrrogada de la fecha
     * * Ingresar la llave subrrogada de la tiempo
     * @return array
     */
    public function stepUpdateKeys() : array
    {
        try {
            # Ingresar la llave subrrogada de la estacion
            if ($this->extractTypeObject->flagStationSk){$this->updateStationSk($this->etlConfig->getStation()->id);}

            # Ingresar la llave subrrogada de la fecha
            if ($this->extractTypeObject->flagDateSk){$this->updateDateSk();}

            # Ingresar la llave subrrogada de la tiempo
            if ($this->extractTypeObject->flagTimeSk){$this->updateTimeSk();}

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * STEP
     * Ejecutar el proceso de confianza y soporte de los datos
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
     * @param $data
     * @return bool
     * @internal param $repository
     */
    private function insertAllDataInTemporal($data)
    {
        $this->insertData('temporary_work',$this->etlConfig->getTableSpaceWork(),($this->extractTypeObject)->columns, $data);
        return true;
    }
}
