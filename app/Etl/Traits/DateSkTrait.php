<?php

namespace App\Etl\Traits;

use Facades\App\Repositories\DataWareHouse\DateDimRepository;

Trait DateSkTrait
{
    /**
     * @param $date
     */
    public function calculateDateSk($date)
    {
        return DateDimRepository::getDateSk($date);
    }

}