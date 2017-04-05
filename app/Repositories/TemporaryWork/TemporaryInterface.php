<?php

namespace App\Repositories\TemporaryWork;

interface TemporaryInterface
{
    public function getDatesDistinct();

    public function getTimesDistinct();

    public function updateDateSk($dateSk, $date);

    public function updateTimeSk($timeSk, $time);

    public function UpdateStationSk($stationId);

    public function truncate();
}