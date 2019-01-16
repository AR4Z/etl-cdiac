<?php

namespace App\Etl;

interface EtlFactoryContract
{
    /**
     * @return mixed
     */
    public function run();
}