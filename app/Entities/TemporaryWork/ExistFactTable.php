<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactTable extends Model
{

    protected $connection = 'temporary_work';

    protected $table = 'exist_fact_weather';

    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
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
