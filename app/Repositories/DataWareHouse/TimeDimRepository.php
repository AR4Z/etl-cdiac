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
}