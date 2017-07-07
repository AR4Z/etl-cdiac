<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class GroundwaterFact extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'groundwater_fact';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['station_sk', 'date_sk', 'time_sk'];

    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'raw_air_pressure',
        'raw_air_temperature',
        'raw_water_pressure',
        'raw_water_temperature',
        'raw_water_level',
        'water_temperature',
        'groundwater_level',
        'hydrostatic_charge',
        'well_quota',
        'depth',
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
