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

    /**
     * @param $timeSk
     * @return mixed
     */
    public function calculateTimeFromTimeSk($timeSk)
    {
        return TimeDimRepository::getTime($timeSk);
    }

    /**
     * @param $space
     * @return mixed
     */
    public function getSerializationTime($space)
    {
        return TimeDimRepository::getTimeFromSpace($space);
    }

    /**
     * @param $space
     * @return mixed
     */
    public function getStandardDataTime($space)
    {
        return TimeDimRepository::getStandardData($this->getSerializationTime($space));
    }
}