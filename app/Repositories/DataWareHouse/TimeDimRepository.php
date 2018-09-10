<?php

namespace App\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\TimeDim;
use DB;

class TimeDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TimeDim::class;

    /**
     * @return mixed
     */
    protected function queryBuilder()
    {
        return DB::connection('data_warehouse')->table('time_dim');
    }

    /**
     * @param $time
     * @return mixed
     */
    public function getTimeSk($time)
    {
        $val = $this->select('time_sk')->where('time',$time)->first();
        return (is_null($val)) ? null : $val->time_sk ;
    }

    /**
     * @param $timeSk
     * @return null
     */
    public function getTime($timeSk)
    {
        $val =  $this->select('time')->where('time_sk',$timeSk)->first();
        return (is_null($val)) ? null : $val->time;
    }

    /**
     * @param $space
     * @return array
     */
    public function getTimeFromSpace($space)
    {
        return range(1,86400,$space);
    }

    /**
     * @param $elements
     * @return mixed
     */
    public function getStandardData($elements)
    {
        return $this->queryBuilder()->select('time_sk','time')->whereIn('time_sk', $elements)->orderBy('time_sk')->get()->toArray();
    }
}