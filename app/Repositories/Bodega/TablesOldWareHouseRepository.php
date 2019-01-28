<?php

namespace App\Repositories\Bodega;


use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\TablesOldWareHouse;

class TablesOldWareHouseRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TablesOldWareHouse::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param int $tabla
     * @return TablesOldWareHouse
     */
    public function getStationIdByName($tabla) : TablesOldWareHouse
    {
        return $this->select('station_dim.estacion_sk','tablas.estacion','tablas.nombre_tabla')
            ->join('station_dim','station_dim.estacion_sk','=', 'tablas.id_tabla')
            ->where('tablas.nombre_tabla','=',$tabla)
            ->where('tablas.activa','=',1)
            ->first();
    }

}