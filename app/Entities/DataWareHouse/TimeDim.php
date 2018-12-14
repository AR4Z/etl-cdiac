<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeDim extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'time_dim';

    /**
     * @var string
     */
    protected $primaryKey = 'time_sk';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'time',
        'hours',
        'minutes',
        'seconds',
        'part_day',
    ];

    /**
     * @return HasMany
     */
    public function weatherRows() : HasMany
    {
        return $this->hasMany(WeatherFact::class, 'time_sk', 'time_sk');
    }

    /**
     * @return HasMany
     */
    public function airRows() : HasMany
    {
        return $this->hasMany(AirFact::class, 'time_sk', 'time_sk');
    }

    /**
     * @return HasMany
     */
    public function groundwaterRows() : HasMany
    {
        return $this->hasMany(GroundwaterFact::class, 'time_sk', 'time_sk');
    }

    /**
     * @return HasMany
     */
    public function correctionHistoryRows() : HasMany
    {
        return $this->hasMany(CorrectionHistory::class, 'time_sk', 'time_sk');
    }
}
