<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\RepositoriesContract;
use Illuminate\Support\Collection;

interface TemporalRepositoryContract extends RepositoriesContract
{
    /**
     * @return array
     */
    public function getDatesDistinct() : array;

    /**
     * @return array
     */
    public function getTimesDistinct() : array;


    /**
     * @param int $dateSk
     * @param string $date
     * @return mixed
     */
    public function updateDateSk(int $dateSk, string $date);

    /**
     * @param $timeSk
     * @param $time
     * @return mixed
     */
    public function updateTimeSk(int $timeSk, string $time);

    /**
     * @param $stationId
     * @return mixed
     */
    public function UpdateStationSk(int $stationId);

    /**
     * @return mixed
     */
    public function truncate();

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function incrementDateSk(int $stationSk, int $value);

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function updateTimeSkFromStationSk(int $stationSk, int $value);

    /**
     * @return Collection
     */
    public function getDateTime() : Collection;
}