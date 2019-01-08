<?php

namespace App\Etl\Run;

class Synchronous extends RunBase implements RunInterface
{
    /**
     * return mixed
     */
    public function execute()
    {
        foreach ($this->etlProcess as $process){ $process->run();}
    }
}