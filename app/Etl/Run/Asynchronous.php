<?php

namespace App\Etl\Run;

use App\Jobs\EtlJobExecution;

class Asynchronous extends RunBase implements RunInterface
{
    /**
     * return mixed
     */
    public function execute()
    {
        EtlJobExecution::dispatch($this->etlProcess);
    }
}