<?php

namespace App\Repositories\Bodega;


use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\TablesOldWareHouse;
use DB;



class TablesOldWareHouseRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TablesOldWareHouse::class)->setRepositoryId('rinvex.repository.uniqueid');
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

    //Auditory System Functions

    /**
     * @param int $tabla
     * @return array
     */
    public function getStationIdByName($tabla)
    {
        return $this
            ->select('station_dim.estacion_sk','tablas.estacion','tablas.nombre_tabla')
            ->join('station_dim','station_dim.estacion_sk','=', 'tablas.id_tabla')
            ->where('tablas.nombre_tabla','=',$tabla)
            ->where('tablas.activa','=',1)
            ->first();
    }

}