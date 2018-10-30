<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactGroundwater extends Model
{
    /**
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * @var string
     */
    protected $table = 'exist_fact_groundwater';

    /**
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk','date_time',
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
