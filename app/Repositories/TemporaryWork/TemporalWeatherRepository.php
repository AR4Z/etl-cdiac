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
        return $this->select('id','date')->distinct()->get()->all();
    }

    /**
     * @return mixed
     */
    public function getTimesDistinct()
    {
        return $this->select('id','time')->distinct()->get()->all();
    }

    /**
     * @param $dateSk
     * @param $date
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateDateSk($dateSk, $date)
    {
        return $this->createModel()->where('date', 'LIKE', $date)->update(['date_sk' => $dateSk]);
    }

    /**
     * @param $timeSk
     * @param $time
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateTimeSk($timeSk, $time)
    {
        return $this->createModel()->where('time', '=', $time)->update(['time_sk' => $timeSk]);
    }

    /**
     * @param $stationId
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function UpdateStationSk($stationId)
    {
        return $this->createModel()->query()->update(['station_sk' => $stationId]);
    }

    /**
     * @return mixed
     */
    public function truncate()
    {
        return DB::Connection('temporary_work')->table('temporal_weather')->truncate();
    }

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function incrementDateSk($stationSk, $value)
    {
        return $this->where('id', '=',$stationSk)->increment('date_sk',$value);
    }

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateTimeSkFromStationSk($stationSk, $value)
    {
        return $this->createModel()->where('id', '=', $stationSk)->update(['time_sk' => $value]);
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->select('id','date_time')->get();
    }

}
