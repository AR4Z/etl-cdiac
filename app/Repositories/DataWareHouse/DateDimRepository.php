<?php

namespace App\Repositories\DataWareHouse;


use Carbon\Carbon;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\DateDim;

class DateDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = DateDim::class;


    /**
     * @param Carbon $date
     * @return mixed
     */
    public function getDateSk(Carbon $date)
    {
        return $this->select('date_sk')
                    ->whereDay('date',$date->day)
                    ->whereMonth('date',$date->month)
                    ->whereYear('date',$date->year)
                    ->first()
                    ->date_sk;
    }

}