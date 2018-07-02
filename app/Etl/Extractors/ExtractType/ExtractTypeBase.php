<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\Extractors\ExtractorBase;

class ExtractTypeBase extends ExtractorBase
{
    /**
     * @param $extractTable
     * @return mixed
     */
    public function setExtractTable($extractTable)
    {
        if (is_null($extractTable)){
            //TODO excepcion por no hallar tabla de extracccion...
        }
        return $extractTable;
    }
}