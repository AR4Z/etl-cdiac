<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};

class Original extends TransformBase implements TransformInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Original';

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
        # Se ejecutan los pasos que se requieren para el proceso (Actualmente ho hay steps)
        # $this->stepsList->runStartList($this->etlConfig->processState,$this);
    }

    /**
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList): StepList
    {
        # $stepList->addStep( new Step('nameStep')); Actaumente ho hay Steps
        return $stepList;
    }
}