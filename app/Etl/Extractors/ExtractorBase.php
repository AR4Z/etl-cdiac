<?php

namespace App\Etl\Extractors;



use Carbon\Carbon;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Etl\Traits\{DateSkTrait, TimeSkTrait};


abstract class ExtractorBase
{
    use DateSkTrait, TimeSkTrait;

    /**
     *
     */
    public function updateDateSk()
    {
        $dates = TemporalWeatherRepository::getDatesDistinct();

        foreach ($dates as $date)
        {
            TemporalWeatherRepository::updateDateSk(
                $this->calculateDateSk(
                    Carbon::parse($date->fecha)
                ),
                $date->fecha
            );
        }

        return;

    }

    public  function updateTimeSk()
    {
        $times = TemporalWeatherRepository::getTimesDistinct();

        foreach ($times as $time)
        {
            TemporalWeatherRepository::updateTimeSk($this->calculateTimeSk($time->hora),$time->hora);
        }
        return;
    }


    public function updateStationSk($station)
    {
        TemporalWeatherRepository::updateStationSk($station->id);
    }
}