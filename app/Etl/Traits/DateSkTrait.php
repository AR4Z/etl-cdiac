<?php

namespace App\Etl\Traits;

use Carbon\Carbon;
use Facades\App\Repositories\DataWareHouse\DateDimRepository;

Trait DateSkTrait
{
    /**
     * @param $date
     * @return mixed
     */
    public function calculateDateSk($date)
    {
        return DateDimRepository::getDateSk($date);
    }

    /**
     * @param $dateSk
     * @return mixed
     */
    public function calculateDateFromDateSk($dateSk)
    {
        return DateDimRepository::getDate($dateSk);
    }

    /**
     * @param $limitInitial
     * @param $limitFinal
     * @param $space
     * @return array
     */
    public function getSerializationDate($limitInitial, $limitFinal, $space)
    {
        if ($limitInitial == $limitFinal){
            return [$this->calculateDateSk(Carbon::parse($limitInitial))];
        }

        return DateDimRepository::getDateFromSpace($this->calculateDateSk(Carbon::parse($limitInitial)),$this->calculateDateSk(Carbon::parse($limitFinal)), $space);
    }

    /**
     * @param array $datesSk
     * @return mixed
     */
    public function getDateAndDateSk(array $datesSk)
    {
        return DateDimRepository::getWhereInDateAndDateSk($datesSk);
    }
}