<?php

namespace App\Repositories\Bodega;


use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\CorrectionHistorical;
use DB;



class CorrectionHistoricalRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(CorrectionHistorical::class)->setRepositoryId('rinvex.repository.uniqueid');
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
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function correctionAverageByStationAndVar($station_id,$var,$date1,$date2){
        return $this
            ->selectRaw('count(id_correccion)')
            ->where('estacion_sk','=',$station_id)
            ->whereBetween('fecha_sk',[$date1,$date2])
            ->where('tipo_correccion_aplicado','=','promedio')
            ->where('variable','=',$var)
            ->get()->toArray();
    }
}