<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class FilterCorrection extends TransformBase implements TransformInterface, StepContract
{
    public $method = 'Correction';

    /**
     * @var EtlConfig
     */
    public $etlConfig = null;

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());
    }

    /**
     *
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
        $stepList->addStep( new Step('stepCorrectionVariables'));
        $stepList->addStep( new Step('stepFilterWindSpeedZero'));

        return $stepList;
    }

    /**
     * STEP
     * Se ejecutan los filtros de correcion respectivos para cada variable
     * @return array
     */
    public function stepCorrectionVariables()
    {
        try {

            $varFilter = $this->etlConfig->getVarForFilter();

            foreach ($varFilter as $variable){
                if ($variable->correction_type){
                    $this->correctControl(
                        $this->etlConfig->getTableSpaceWork(),
                        $variable,
                        $this->etlConfig->getIncomingAmount()
                    );
                }
            }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Se ejecuta filtro espefico de la variable wind_speed
     * @return array
     */
    public function stepFilterWindSpeedZero()
    {
        try {

            if (is_numeric (array_search('wind_speed', array_column($this->etlConfig->getVarForFilter()->toArray(),'local_name')))){
                $this->filterWindSpeedZero();
            }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

}