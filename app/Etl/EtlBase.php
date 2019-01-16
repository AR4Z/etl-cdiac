<?php

namespace App\Etl;

use App\Etl\Traits\{CorrectMethod,DateSkTrait,RemoveAccents,TimeSkTrait,WorkDatabaseTrait};
use App\Etl\Database\DatabaseConfig;

class EtlBase
{
    use DateSkTrait,TimeSkTrait,CorrectMethod,RemoveAccents, WorkDatabaseTrait,DatabaseConfig; #TrustTrait

    /**
     * @var EtlConfig
     */
    public $etlConfig;

    /**
     * @return EtlConfig
     */
    public function getEtlConfig(): EtlConfig
    {
        return $this->etlConfig;
    }

    /**
     * @param EtlConfig $etlConfig
     */
    public function setEtlConfig(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
    }


}

