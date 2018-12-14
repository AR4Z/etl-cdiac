<?php

namespace App\Repositories\Config;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Station;
use DB;

class StationRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Station::class)->setRepositoryId('rinvex.repository.uniqueid');
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
     * @param int $stationId
     * @return Station
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function findRelationship(int $stationId) : Station
    {
        return $this->createModel()
                    ->with(['originalState', 'filterState', 'varForStation', 'varForStation.variable'])
                    ->find($stationId);
    }

    /**
     * @param int $stationId
     * @return Collection
     */
    public function findVarForFilter(int $stationId) : Collection
    {
        return DB::connection('config')
            ->table('variable')
            ->select('variable.*','var_for_station.*')
            ->where('var_for_station.station_id',  $stationId)
            ->join('var_for_station', 'variable.id', '=', 'var_for_station.variable_id')
            ->get();
    }

    /**
     * @return Collection
     */
    public function getActive() : Collection
    {
        return $this->where('active', true)->get();
    }



}
