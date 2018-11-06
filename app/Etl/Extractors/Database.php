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

    /**############################################ STEP SECTION ################################################### **/

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
            ($this->etlConfig->keys)->config(
                $this->etlConfig->typeProcess,
                ($this->etlConfig->station)->typeStation->etl_method,
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

            $values = ($this->extractTypeObject)->extractData(
                $this->etlConfig->keys,
                $this->etlConfig->initialDate,
                $this->etlConfig->initialTime,
                $this->etlConfig->finalDate,
                $this->etlConfig->finalTime,
                10000
            );

            if (is_null($values) or count($values) ==  0){
                return [
                    'resultExecution'   => false,
                    'data'              => null,
                    'exception'         => null,
                    'error'             => "Error : No hay Datos para esta estacion  en estas fechas: ".$this->etlConfig->initialDate." ". $this->etlConfig->initialTime." -- ".$this->etlConfig->finalDate." ".$this->etlConfig->finalTime
                ];
            }

            $this->insertAllDataInTemporal($values);

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
            if ($this->extractTypeObject->flagStationSk){$this->updateStationSk(($this->etlConfig->station)->id);}

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

    /**############################################ END STEP SECTION ################################################### **/

    /**############################################ SET SECTION ################################################### **/

    /**
     * @param string $extractType
     */
    public function setExtractType(string $extractType = 'External')
    {
        $this->extractType = $extractType;
    }

    /**
     * @param bool $truncateTemporal
     */
    public function setTruncateTemporal(bool $truncateTemporal = true)
    {
        $this->truncateTemporal = $truncateTemporal;
    }

    /**######################################### END  SET SECTION ################################################# **/

    /**############################################ PRIVATE SECTION ################################################### **/

    /**
     * @param $data
     * @return bool
     * @internal param $repository
     */
    private function insertAllDataInTemporal($data)
    {
        $this->insertDataWDT('temporary_work',($this->extractTypeObject)->columns, $data);
        return true;
    }

    /**############################################ END PRIVATE SECTION ################################################### **/
}
