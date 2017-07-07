<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class WeatherReliability extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'weather_reliability';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['station_sk', 'date_sk'];

    protected $fillable = [
        'station_sk', 'date_sk',
        'rainfall_total_records',
        'rainfall_correct_records',
        'rainfall_support',
        'rainfall_trust',

        'temperature_total_records',
        'temperature_correct_records',
        'temperature_support',
        'temperature_trust',

        'brightness_total_records',
        'brightness_correct_records',
        'brightness_support',
        'brightness_trust',

        'relative_humidity_total_records',
        'relative_humidity_correct_records',
        'relative_humidity_support',
        'relative_humidity_trust',

        'water_level_total_records',
        'water_level_correct_records',
        'water_level_support',
        'water_level_trust',

        'flow_rate_total_records',
        'flow_rate_correct_records',
        'flow_rate_support',
        'flow_rate_trust',

        'wind_speed_total_records',
        'wind_speed_correct_records',
        'wind_speed_support',
        'wind_speed_trust',

        'wind_direction_total_records',
        'wind_direction_correct_records',
        'wind_direction_support',
        'wind_direction_trust',

        'barometric_pressure_total_records',
        'barometric_pressure_correct_records',
        'barometric_pressure_support',
        'barometric_pressure_trust',

        'evapotranspiration_total_records',
        'evapotranspiration_correct_records',
        'evapotranspiration_support',
        'evapotranspiration_trust',

        'solar_radiation_total_records',
        'solar_radiation_correct_records',
        'solar_radiation_support',
        'solar_radiation_trust',
    ];

    public function station(){
        return $this->belongsTo(StationDim::class, 'station_sk', 'station_sk');
    }

    public function date(){
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }
}
