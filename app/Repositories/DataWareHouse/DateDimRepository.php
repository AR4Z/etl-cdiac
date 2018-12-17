<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\RepositoriesContract;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\DateDim;
use DB;

class DateDimRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(DateDim::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getWhereInDateAndDateSk($datesSk)
    {
        return $this->queryBuilder()->select('date_sk','date')->whereIn('date_sk',$datesSk)->get()->toArray();
    }
}