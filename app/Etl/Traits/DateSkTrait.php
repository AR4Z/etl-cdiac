<?php

namespace App\Etl\Traits;

use Carbon\Carbon;
use Facades\App\Repositories\DataWareHouse\DateDimRepository;

Trait DateSkTrait
{
    /**
     * @param $date
     * @return
     */
    public function calculateDateSk($date)
    {
        return DateDimRepository::getDateSk($date);
    }

    public function calculateDateFromDateSk($dateSk)
    {
        return DateDimRepository::getDate($dateSk);
    }
    public function getSerializationDate($limitInitial,$limitFinal,$space)
    {
        if ($limitInitial == $limitFinal){
            return [$this->calculateDateSk(Carbon::parse($limitInitial))];
        }

        return DateDimRepository::getDateFromSpace($this->calculateDateSk(Carbon::parse($limitInitial)),$this->calculateDateSk(Carbon::parse($limitFinal)), $space);
    }
}