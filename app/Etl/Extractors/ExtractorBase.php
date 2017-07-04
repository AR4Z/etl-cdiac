<?php

namespace App\Etl\Extractors;

use Carbon\Carbon;
use App\Etl\Traits\{DateSkTrait, TimeSkTrait};


/**
 * @property bool flagTimeSk
 * @property bool flagDateSk
 * @property bool flagStationSk
 */
abstract class ExtractorBase
{
    use DateSkTrait, TimeSkTrait;

    /**
     * @param $repository
     * @return bool
     */
    public function updateDateSk($repository)
    {
        $dates = ($repository)::getDatesDistinct();
        foreach ($dates as $date){($repository)::updateDateSk($this->calculateDateSk(Carbon::parse($date->fecha)),$date->fecha);}
        $this->flagDateSk = true;
    }

    /**
     * @param $repository
     * @return void
     */
    public  function updateTimeSk($repository)
    {
        $times = ($repository)::getTimesDistinct();
        foreach ($times as $time){($repository)::updateTimeSk($this->calculateTimeSk($time->hora),$time->hora);}
        $this->flagTimeSk = true;
    }


    /**
     * @param $station
     * @param $repository
     * @return bool
     */
    public function updateStationSk($station, $repository)
    {
        ($repository)::updateStationSk($station->id);
        $this->flagStationSk = true;
    }


    /**
     * @param $repository
     * @return mixed
     */
    public function truncateTemporalWork($repository)
    {
        return ($repository)::truncate();
    }
}