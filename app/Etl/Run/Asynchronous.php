<?php

namespace App\Etl\Run;

use App\Etl\EtlFactoryContract;
use App\Jobs\EtlJobExecution;

class Asynchronous extends RunBase implements RunInterface
{
    /**
     * return mixed
     */
    public function execute()
    {
        dd($this->etlProcess);
        EtlJobExecution::dispatch($this->etlProcess);
    }
}