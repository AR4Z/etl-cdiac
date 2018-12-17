<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\StationDim;
use DB;

class StationDimRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(StationDim::class)->setRepositoryId('rinvex.repository.uniqueid');
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

    public function getDifferentNetName()
    {
        return $this->select('net_name as id','net_name as name')->distinct('net_name')->pluck('id','name');
    }

    public function getStationsForNet($netName)
    {
        return $this->select('station_sk as id','name')->where('net_name','=',$netName)->orderby('name','ASC')->get();
    }

    public function getIdAndNameStations()
    {
        return $this->select('station_sk as id','name')->orderby('name','ASC')->get();
    }

    public function getIdStationForName($netName)
    {
        return $this->select('station_sk as id')->where('net_name',$netName)->first();
    }
}