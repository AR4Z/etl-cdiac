<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporalWeather extends Model
{
    /**
     * The database TemporalWalther used by the model.
     *
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table= 'temporal_weather';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'date','time',
        'rainfall',
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
        'solar_radiation',
        'comment',
    ];
}
