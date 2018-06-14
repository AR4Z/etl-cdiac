<?php

namespace App\Repositories\TemporaryWork;

interface TemporaryInterface
{
    /**
     * @return mixed
     */
    public function getDatesDistinct();

    /**
     * @return mixed
     */
    public function getTimesDistinct();

    public function updateDateSk($dateSk, $date);

    /**
     * @param $timeSk
     * @param $time
     * @return mixed
     */
    public function updateTimeSk($timeSk, $time);

    /**
     * @param $stationId
     * @return mixed
     */
    public function UpdateStationSk($stationId);

    /**
     * @return mixed
     */
    public function truncate();

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function incrementDateSk($stationSk, $value);

    /**
     * @param $stationSk
     * @param $value
     * @return mixed
     */
    public function updateTimeSkFromStationSk($stationSk, $value);

    /**
     * @return mixed
     */
    public function getDateTime();
}