<?php

namespace App\Etl\Steps;

interface StepContract
{
    /**
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList): StepList;

}