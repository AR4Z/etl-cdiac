<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\BaseFactStructureContract;
use Illuminate\Support\Collection;

interface TemporalRepositoryContract extends BaseFactStructureContract
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


    // NUEVAS

    /**
     * @param string $select
     * @return mixed
     */
    public function getAllDataPersonalSelect(string $select = '*');

    /**
     * @return int
     */
    public function getIncomingAmount() : int;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getLastMigrateData();

    /**
     * @param $stationSk
     * @param $dateSk
     * @param $initTimeSk
     * @param $finalTimeSk
     * @return Collection
     */
    public function getValInRange($stationSk,$dateSk, $initTimeSk, $finalTimeSk) : Collection;

    /**
     * @return mixed
     */
    public function getInitialData();

    /**
     * @return mixed
     */
    public function getFinalData();

    /**
     * @param string $variable
     * @param array $search
     * @return Collection
     */
    public function getVariableToSearchLimit(string $variable, array $search) : Collection;

    /**
     * @param int $stationSk
     * @return array
     */
    public function getDuplicates(int $stationSk) : array;

    /**
     * @param int $timeSk
     * @param null $time
     * @return mixed
     */
    public function updateTimeFromTimeSk(int $timeSk, $time = null);

    /**
     * @param int $dateSk
     * @param null $date
     * @return mixed
     */
    public function updateDateFromDateSk(int $dateSk, $date = null);

    /**
     * @param string $key
     * @param string $column
     * @return array
     */
    public function selectColumnWhereNull(string $key, string $column) : array;

    /**
     * @return mixed
     */
    public function getIdAndDateTime() : Collection;

    /**
     * @param string $variable
     * @return mixed
     */
    public function deleteNullVariable(string $variable);

    /**
     * @param string $commentInit
     * @param string $commentFinal
     * @return array
     */
    public function gerElementsWhereInComments(string $commentInit, string $commentFinal) : array;
}