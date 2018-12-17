<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherFact extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'weather_fact';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'station_sk';

    /**
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk','date_time',
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
    public function time() : BelongsTo
    {
        return $this->belongsTo(TimeDim::class, 'time_sk', 'time_sk');
    }

}
