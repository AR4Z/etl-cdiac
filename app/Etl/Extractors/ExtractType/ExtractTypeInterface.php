<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;

interface ExtractTypeInterface
{
    /**
     * ExtractTypeInterface constructor.
     * @param $etlConfig
     */
    public function __construct(EtlConfig $etlConfig);

    /**
     * @param $variables
     * @param $foreignKey
     * @return mixed
     */
    public function setSelect($variables,$foreignKey);

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function extractData(EtlConfig $etlConfig);

}