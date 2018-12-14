<?php

namespace App\Repositories\Bodega;


use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\StationDim;
use DB;



class StationDimOldRepository extends EloquentRepository implements RepositoriesContract
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

    // Auditory System Functions
    /**
     * @return array
     */
    public function stations(){
        return $this
            ->select('estacion_sk', 'estacion')
            ->where('tipologia',"=",'M')
            ->OrWhere('tipologia','=','H')
            ->where('fin_funcionamiento',null)
            ->where('visible',TRUE)
            ->orderby('estacion','ASC')
            ->get();
    }
    /**
     * @return array
     */
    public function getAllStations(){
        return $this
            ->select('*')
            ->where('tipologia',"=",'M')
            ->OrWhere('tipologia','=','H')
            ->where('fin_funcionamiento',null)
            ->where('visible',TRUE)
            ->orderby('estacion','ASC')
            ->get()->toarray();
    }
    /**
     * @param int $station_id
     * @return array
     */
    public function getStationNameById($station_id)
    {
        return $this
            ->select('estacion_sk','estacion')
            ->where('estacion_sk','=',$station_id)
            ->get()->toArray();
    }

}