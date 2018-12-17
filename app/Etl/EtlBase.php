<?php

namespace App\Etl;

use App\Etl\Traits\{CorrectMethod,DateSkTrait,RemoveAccents,TimeSkTrait,TrustTrait,WorkDatabaseTrait};
use App\Etl\Database\DatabaseConfig;

class EtlBase
{
    use TrustTrait,DateSkTrait,TimeSkTrait,CorrectMethod,RemoveAccents, WorkDatabaseTrait,DatabaseConfig;

    /**
     * @var EtlConfig
     */
    public $etlConfig;
}

