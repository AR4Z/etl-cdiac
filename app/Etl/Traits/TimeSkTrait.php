<?php

namespace App\Etl\Traits;

use Facades\App\Repositories\DataWareHouse\TimeDimRepository;

trait TimeSkTrait
{
    public $maxValueSk = 86400;

    /**
     * @param $time
     * @return mixed
     */

    public function calculateTimeSk($time)
    {
        $completeTime = TimeDimRepository::getTimeSk($time);

        if ($completeTime){return $completeTime;}
    }

    public function calculateTimeFromTimeSk($timeSk)
    {
        return TimeDimRepository::getTime($timeSk);
    }

    public function getSerializationTime($space)
    {
        return TimeDimRepository::getTimeFromSpace($space);
    }
}