<?php

namespace App\Etl\Transformers;


use App\Etl\EtlConfig;

interface TransformInterface
{
    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig);

    public function transform();
}