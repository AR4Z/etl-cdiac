<?php

namespace app\Etl\Traits;

use Facades\App\Repositories\DataWareHouse\TimeDimRepository;

trait TimeSkTrait
{
    /**
     * @param $time
     * @return mixed
     */
    public function calculateTimeSk($time)
    {
        $completeTime = TimeDimRepository::getTimeSk($time);

        if ($completeTime){
            return $completeTime;
        }


    }
}