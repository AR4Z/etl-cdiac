<?php

namespace App\Etl\Run;

use App\Etl\EtlBase;
use App\Etl\EtlFactoryContract;

class RunBase extends EtlBase
{
    /**
     * @var EtlFactoryContract[]
     */
    protected $etlProcess;

    /**
     * @param EtlFactoryContract[] $etlProcess
     */
    public function setEtlProcess(array $etlProcess)
    {
        $this->etlProcess = $etlProcess;
    }
}