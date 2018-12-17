<?php

namespace App\Etl\Run;

interface RunInterface
{
    /**
     * return mixed
     */
    public function execute();
}