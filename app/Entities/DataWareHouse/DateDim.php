<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DateDim extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'date_dim';

    /**
     * @var string
     */
    protected $primaryKey = 'date_sk';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'date',
        'year',
        'month',
        'day',
        'week_day',
        'week_year',
        'quarter',
        'semester',
        'lustrum',
        'month_name',
        'day_name',
    ];

    /**
     * @return HasMany
     */
    public function inventoryRows() : HasMany
    {
        return $this->hasMany(InventoryFact::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function weatherRows() : HasMany
    {
        return $this->hasMany(WeatherFact::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function airRows() : HasMany
    {
        return $this->hasMany(AirFact::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function groundwaterRows() : HasMany
    {
        return $this->hasMany(GroundwaterFact::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function airReliabilityRows() : HasMany
    {
        return $this->hasMany(AirReliability::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function correctionHistoryRows() : HasMany
    {
        return $this->hasMany(CorrectionHistory::class, 'date_sk', 'date_sk');
    }

    /**
     * @return HasMany
     */
    public function weatherReliabilityRows() : HasMany
    {
        return $this->hasMany(WeatherReliability::class, 'date_sk', 'date_sk');
    }
}
