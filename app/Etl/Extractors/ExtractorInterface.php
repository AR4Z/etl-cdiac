<?php

namespace App\Etl\Extractors;


use App\Etl\EtlConfig;

interface ExtractorInterface
{
    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig);

    /**
     * Punto de acceso para ejecutar funcionalidad
     * @return mixed
     */
    public function run();
}