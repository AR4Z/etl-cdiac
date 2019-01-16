<?php

namespace App\Etl\Execution\Options;


interface OptionContract
{
    /**
     * @param string $typeProcess
     * @param array $executionParams
     * @return array
     */
    public function runConfig(string $typeProcess,array $executionParams) : array;
}