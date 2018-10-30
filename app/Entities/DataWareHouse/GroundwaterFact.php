<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroundwaterFact extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'groundwater_fact';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $primaryKey = ['station_sk', 'date_sk', 'time_sk'];

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

    /**
     * @return BelongsTo
     */
    public function station() : BelongsTo
    {
        return $this->belongsTo(StationDim::class, 'station_sk', 'station_sk');
    }

    /**
     * @return BelongsTo
     */
    public function date() : BelongsTo
    {
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }

    /**
     * @return BelongsTo
     */
    public function time() :BelongsTo
    {
        return $this->belongsTo(TimeDim::class, 'time_sk', 'time_sk');
    }
}
