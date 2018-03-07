<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class WeatherFact extends Model
{
    protected $connection = 'data_warehouse';
    
    protected $table = 'weather_fact';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['station_sk', 'date_sk', 'time_sk'];

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

    public function station(){
        return $this->belongsTo(StationDim::class, 'station_sk', 'station_sk');
    }

    public function date(){
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }

    public function time(){
        return $this->belongsTo(TimeDim::class, 'time_sk', 'time_sk');
    }

}
