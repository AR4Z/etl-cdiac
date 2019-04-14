<?php

namespace App\Etl\Execution;


abstract class ExecuteStrategy
{
    /**
     * @param array $executionParams
     * @return array
     */
    abstract public function execute(array $executionParams = []) : array;
}