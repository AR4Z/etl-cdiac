<?php

namespace App\Repositories\Bodega;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Entities\Bodega\StationDim;

class StationDimOldRepository extends AppBaseRepository implements RepositoriesContract
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
     * @return Collection
     */
    public function stations() : Collection
    {
        return $this->select('estacion_sk', 'estacion')
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
    public function getAllStations() : array
    {
        return $this->select('*')
            ->where('tipologia',"=",'M')
            ->OrWhere('tipologia','=','H')
            ->where('fin_funcionamiento',null)
            ->where('visible',TRUE)
            ->orderby('estacion','ASC')
            ->get()
            ->toarray();
    }

    /**
     * @param int $station_id
     * @return array
     */
    public function getStationNameById($station_id) : array
    {
        return $this->select('estacion_sk','estacion')
            ->where('estacion_sk','=',$station_id)
            ->get()
            ->toArray();
    }
}