<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporalWeather;
use DB;

class TemporalWeatherRepository extends EloquentRepository implements RepositoriesContract,TemporaryInterface
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
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateDateSk(int $dateSk, string $date)
    {
        return $this->createModel()->where('date', 'LIKE', $date)->update(['date_sk' => $dateSk]);
    }

    /**
     * @param int $timeSk
     * @param string $time
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateTimeSk(int $timeSk, string $time)
    {
        return $this->createModel()->where('time', '=', $time)->update(['time_sk' => $timeSk]);
    }

    /**
     * @param int $stationId
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function UpdateStationSk(int $stationId)
    {
        return $this->createModel()->query()->update(['station_sk' => $stationId]);
    }

    /**
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateTimeSkFromStationSk(int $stationSk, int $value)
    {
        return $this->createModel()->where('id', '=', $stationSk)->update(['time_sk' => $value]);
    }

    /**
     * @return Collection
     */
    public function getDateTime() : Collection
    {
        return $this->select('id','date_time')->get();
    }
}
