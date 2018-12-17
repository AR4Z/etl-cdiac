<?php

namespace App\Etl\Run;

use App\Etl\EtlBase;
use App\Etl\EtlFactoryContract;

class RunBase extends EtlBase
{
    /**
     * @var EtlFactoryContract[]
     */
    public $etlProcess;
}