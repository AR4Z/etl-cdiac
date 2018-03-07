<?php

namespace App\Etl\Loaders;


use App\Etl\EtlConfig;

interface LoadInterface
{

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig);

    public function run();
}