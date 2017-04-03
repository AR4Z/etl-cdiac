<?php

namespace App\Repositories\TemporaryWork;

use App\Entities\TemporaryWork\TemporalWeather;
use Carbon\Carbon;
use DB;
use Rinvex\Repository\Repositories\EloquentRepository;


class TemporalWeatherRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TemporalWeather::class;

    /**
     * @param $data
     * @return bool
     */
    public function insert($data){

        foreach ($data as $row){
            $this->createModel()->create($row);
            dd($row);
        }
        return true;
    }


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

    /**
     * @param int $dateSk
     * @param Carbon $date
     * @return mixed
     */
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
        return DB::Connection('temporary_work')->table('temporal_weather')->truncate();
    }

}
