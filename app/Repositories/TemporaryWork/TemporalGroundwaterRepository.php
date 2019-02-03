<?php

namespace App\Repositories\TemporaryWork;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Entities\TemporaryWork\TemporalGroundwater;

class TemporalGroundwaterRepository extends TemporalBaseRepository implements TemporalRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TemporalGroundwater::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return array
     */
    public function getDatesDistinct() : array
    {
        return $this->select('id','date')->distinct()->get()->all();
    }

    /**
     * @return array
     */
    public function getTimesDistinct() : array
    {
        return $this->select('id','time')->distinct()->get()->all();
    }

    /**
     * @param $dateSk
     * @param $date
     * @return mixed
     */
    public function updateDateSk(int $dateSk, string $date)
    {
        return $this->queryBuilder()->where('date', 'LIKE', $date)->update(['date_sk' => $dateSk]);
    }

    /**
     * @param $timeSk
     * @param $time
     * @return mixed
     */
    public function updateTimeSk(int $timeSk, string $time)
    {
        return $this->queryBuilder()->where('time', '=', $time)->update(['time_sk' => $timeSk]);
    }

    /**
     * @param $stationId
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
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function incrementDateSk(int $stationSk, int $value)
    {
        return $this->where('id', '=',$stationSk)->increment('date_sk',$value);
    }

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function updateTimeSkFromStationSk(int $stationSk, int $value)
    {
        return $this->queryBuilder()->where('id', '=', $stationSk)->update(['time_sk' => $value]);
    }

    /**
     * @return Collection
     */
    public function getDateTime() : Collection
    {
        return $this->select('id','date_time')->get();
    }

    /**
     * @param string $variable
     * @return mixed
     */
    public function deleteNullVariable(string $variable)
    {
        return $this->queryBuilder()->whereNull($variable)->delete();
    }
}