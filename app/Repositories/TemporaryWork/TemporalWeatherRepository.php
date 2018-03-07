<?php

namespace App\Repositories\TemporaryWork;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporalWeather;
use DB;



class TemporalWeatherRepository extends EloquentRepository implements TemporaryInterface
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TemporalWeather::class;

    /**
     * @return mixed
     */
    public function getDatesDistinct()
    {
        return $this->select('date')->distinct()->get()->all();
    }

    public function getTimesDistinct()
    {
        return $this->select('time')->distinct()->get()->all();
    }

    /**
     * @param int $dateSk
     * @param $date
     * @return mixed
     */
    public function updateDateSk($dateSk, $date)
    {
        return $this->createModel()->where('date', 'LIKE', $date)->update(['date_sk' => $dateSk]);
    }

    public function updateTimeSk($timeSk, $time)
    {
        return $this->createModel()->where('time', '=', $time)->update(['time_sk' => $timeSk]);
    }

    public function UpdateStationSk($stationId)
    {
        return $this->createModel()->query()->update(['station_sk' => $stationId]);
    }
    
    public function truncate()
    {
        return DB::Connection('temporary_work')->table('temporal_weather')->truncate();
    }

}
