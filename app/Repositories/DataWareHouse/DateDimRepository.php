<?php

namespace App\Repositories\DataWareHouse;


use Carbon\Carbon;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\DateDim;
use DB;

class DateDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = DateDim::class;
    /**
     * @return mixed
     */
    protected function queryBuilder()
    {
        return DB::connection('data_warehouse')->table('date_dim');
    }

    /**
     * @param Carbon $date
     * @return mixed
     */
    public function getDateSk(Carbon $date)
    {
        $val = $this->select('date_sk')->whereDay('date',$date->day)->whereMonth('date',$date->month)->whereYear('date',$date->year)->first();
        return (is_null($val)) ? null : $val->date_sk;
    }

    /**
     * @param $dateSk
     * @return null
     */
    public function getDate($dateSk)
    {
        $val =  $this->select('date')->where('date_sk',$dateSk)->first();
        return (is_null($val)) ? null : $val->date;
    }

    /**
     * @param $initialLimit
     * @param $finalLimit
     * @param $space
     * @return array
     */
    public function getDateFromSpace($initialLimit, $finalLimit, $space)
    {
        return range($initialLimit,$finalLimit,$space);
    }

    /**
     * @param $datesSk
     * @return mixed
     */
    public function getWhereInDateAndDateSk($datesSk)
    {
        return $this->queryBuilder()->select('date_sk','date')->whereIn('date_sk',$datesSk)->get()->toArray();
    }

}