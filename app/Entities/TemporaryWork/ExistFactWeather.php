<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactWeather extends Model
{
    /**
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * @var string
     */
    protected $table = 'exist_fact_weather';

    /**
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk','date_time',
        'rainfall',
        'accumulated_rainfall',
        'temperature',
        'max_temperature',
        'min_temperature',
        'avg_temperature',
        'brightness',
        'relative_humidity',
        'water_level',
        'flow_rate',
        'wind_speed',
        'wind_direction',
        'barometric_pressure',
        'evapotranspiration',
        'accumulated_evapotranspiration',
        'solar_radiation',
        'comment',
    ];
}
