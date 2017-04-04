<?php

namespace App\Etl\Extractors;



use Carbon\Carbon;
use App\Etl\Traits\{DateSkTrait, TimeSkTrait};


abstract class ExtractorBase
{
    use DateSkTrait, TimeSkTrait;

    /**
     * @param $repository
     */
    public function updateDateSk($repository)
    {
        $dates = ($repository)::getDatesDistinct();

        foreach ($dates as $date)
        {
            ($repository)::updateDateSk(
                $this->calculateDateSk(
                    Carbon::parse($date->fecha)
                ),
                $date->fecha
            );
        }

        return;

    }

    /**
     * @param $repository
     */
    public  function updateTimeSk($repository)
    {
        $times = ($repository)::getTimesDistinct();

        foreach ($times as $time)
        {
            ($repository)::updateTimeSk($this->calculateTimeSk($time->hora),$time->hora);
        }
        return;
    }


    /**
     * @param $station
     * @param $repository
     */
    public function updateStationSk($station, $repository)
    {
        ($repository)::updateStationSk($station->id);
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