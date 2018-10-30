<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\TimeDim;
use DB;

class TimeDimRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TimeDim::class)->setRepositoryId('rinvex.repository.uniqueid');
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStandardData($elements)
    {
        return $this->queryBuilder()->select('time_sk','time')->whereIn('time_sk', $elements)->orderBy('time_sk')->get()->toArray();
    }


}