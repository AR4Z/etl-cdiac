<?php

namespace App\Etl\Run;

use App\Etl\EtlFactoryContract;

class RunSynchronous extends RunBase implements RunInterface
{
    /**
     * return mixed
     */
    public function execute()
    {
        foreach ($this->etlProcess as $process){ $process->run();}
    }
}