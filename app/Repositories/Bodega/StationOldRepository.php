<?php

namespace App\Repositories\Bodega;


use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\Station;

class StationOldRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

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