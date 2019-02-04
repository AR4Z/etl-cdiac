<?php

namespace App\Repositories\TemporaryWork;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Entities\TemporaryWork\TemporalWeather;

class TemporalWeatherRepository extends TemporalBaseRepository implements TemporalRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TemporalWeather::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return mixed
     */
    public function getDatesDistinct() : array
    {
        return $this->select('id','date')->distinct()->get()->all();
    }

    /**
     * @return mixed
     */
    public function getTimesDistinct() : array
    {
        return $this->select('id','time')->distinct()->get()->all();
    }

    /**
     * @param int $dateSk
     * @param string $date
     * @return mixed
     */
    public function updateDateSk(int $dateSk, string $date)
    {
        return $this->queryBuilder()->where('date', 'LIKE', $date)->update(['date_sk' => $dateSk]);
    }

    /**
     * @param int $timeSk
     * @param string $time
     * @return mixed
     */
    public function updateTimeSk(int $timeSk, string $time)
    {
        return $this->queryBuilder()->where('time', '=', $time)->update(['time_sk' => $timeSk]);
    }

    /**
     * @param int $stationId
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function UpdateStationSk(int $stationId) /*TODO REVISAR ESTE METODO*/
    {
        return $this->createModel()->query()->update(['station_sk' => $stationId]);
    }

    /**
     * @return mixed
     */
    public function truncate()
    {
        $this->queryBuilder()->truncate();
    }

    /**
     * @param int $stationSk
     * @param int $value
     * @return mixed
     */
    public function incrementDateSk(int $stationSk, int $value)
    {
        return $this->where('id', '=',$stationSk)->increment('date_sk',$value);
    }

    /**
     * @param int $stationSk
     * @param int $value
     * @return mixed
     */
    public function updateTimeSkFromStationSk(int $stationSk, int $value)
    {
        return $this->queryBuilder()->where('id', '=', $stationSk)->update(['time_sk' => $value]);
    }
}
