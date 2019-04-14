<?php

namespace App\Etl\Execution\Options\FilterOptions;

use App\Etl\Execution\Options\OptionContract;

interface FilterOptionContract extends OptionContract
{
    /**
     * @param string $typeProcess
     * @param array $executionParams
     * @return array
     */
    public function runConfig(string $typeProcess,array $executionParams) : array;
}