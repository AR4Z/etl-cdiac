<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporalGroundwater extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'temporal_groundwater';

    protected $fillable = [
        'id','station_sk', 'date_sk', 'time_sk',
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
}
