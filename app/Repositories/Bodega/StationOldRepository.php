<?php

namespace App\Repositories\Bodega;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Bodega\Station;

class StationOldRepository extends AppBaseRepository implements RepositoriesContract
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
     * @param int $station_id
     * @return array
     */
    public function getStationDate($station_id) : array
    {
        return $this->select('estacion_sk','total_medicion_dia')->where('estacion_sk','=',$station_id)->get()->toArray();
    }

    /**
     * @param int $station_id
     * @return array
     */
    public function dates($station_id) : array
    {
        return $this->selectRaw('total_medicion_dia')->where('estacion_sk','=',$station_id)->get()->toArray();
    }
}