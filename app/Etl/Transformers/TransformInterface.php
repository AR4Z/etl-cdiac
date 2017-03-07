<?php

namespace App\Etl\Transform;


use App\Etl\EtlConfig;

interface TransformInterface
{
    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig);
}