<?php

namespace App\Repositories\DataWareHouse;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\TimeDim;

class TimeDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TimeDim::class;

    /**
     * @param $time
     * @return mixed
     */
    public function getTimeSk($time){

        return $this->select('time_sk')
            ->where('time',$time)
            ->first()
            ->time_sk;
    }

    public function getTime($timeSk)
    {
        return $this->select('time')
            ->where('time_sk',$timeSk)
            ->first()
            ->time;
    }
    public function getTimeFromSpace($space)
    {
        return range(1,86400,$space);
    }
}