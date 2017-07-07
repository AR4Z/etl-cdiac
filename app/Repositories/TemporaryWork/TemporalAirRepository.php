<?php

namespace App\Repositories\TemporaryWork;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporalAir;
use DB;


class TemporalAirRepository extends EloquentRepository implements TemporaryInterface
{
    protected $repositoryId = 'rinvex.repository.uniqueid';
    protected $model = TemporalAir::class;


    /**
     * @return mixed
     */
    public function getDatesDistinct()
    {
        return $this->select('fecha')->distinct()->get()->all();
    }

    public function getTimesDistinct()
    {
        return $this->select('hora')->distinct()->get()->all();
    }

    public function updateDateSk($dateSk, $date)
    {
        return $this->createModel()->where('fecha', 'LIKE', $date)->update(['fecha_sk' => $dateSk]);
    }

    public function updateTimeSk($timeSk, $time)
    {

        return $this->createModel()->where('hora', '=', $time)->update(['tiempo_sk' => $timeSk]);
    }

    public function UpdateStationSk($stationId)
    {
        return $this->createModel()->query()->update(['estacion_sk' => $stationId]);
    }

    public function truncate()
    {
        return DB::Connection('temporary_work')->table('temporal_Air')->truncate();
    }

}