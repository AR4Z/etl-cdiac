<?php

namespace App\Etl\Steps;

use App\Etl\EtlState;

class StepList
{
    /**
     * @var array
     */
    private $steps = [];

    /**
     * @param Step $step
     */
    public function addStep(Step $step)
    {
        array_push($this->steps, $step);
    }

    /**
     * @param int $position
     * @return Step
     */
    public function getStep(int $position) : Step
    {
        return $this->steps[$position];
    }

    /**
     * @return array
     */
    public function getSteps() : array
    {
        return $this->steps;
    }

    /**
     * @param EtlState $etlState
     * @param $process
     */
    public function runStartList(EtlState $etlState, $process)
    {
        foreach ( $this->steps as $step){ $step->start($etlState,$process); }
    }

}