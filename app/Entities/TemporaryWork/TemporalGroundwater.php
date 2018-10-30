<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporalGroundwater extends Model
{
    /**
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * @var string
     */
    protected $table = 'temporal_groundwater';

    /**
     * @var array
     */
    protected $fillable = [
        'id','station_sk', 'date_sk', 'time_sk','date_time',
        'date','time',
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
