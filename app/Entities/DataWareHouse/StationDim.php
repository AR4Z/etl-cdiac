<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StationDim extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'station_dim';

    /**
     * @var string
     */
    protected $primaryKey = 'station_sk';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'net_name',
        'typology',
        'city',
        'location',
        'latitude',
        'longitude',
        'altitude',
        'owner',
        'start_operation',
        'finish_operation',
        'comment',
        'basin',
        'sub_basin',
        'active',
        'community_station',
    ];

    /**
     * @return HasMany
     */
    public function weatherRows() : HasMany
    {
        return $this->hasMany(WeatherFact::class, 'station_sk', 'station_sk');
    }

    /**
     * @return HasMany
     */
    public function airRows() : HasMany
    {
        return $this->hasMany(AirFact::class, 'station_sk', 'station_sk');
    }

    /**
     * @return HasMany
     */
    public function groundwaterRows() : HasMany
    {
        return $this->hasMany(GroundwaterFact::class, 'station_sk', 'station_sk');
    }

    /**
     * @return HasMany
     */
    public function airReliabilityRows() : HasMany
    {
        return $this->hasMany(AirReliability::class, 'station_sk', 'station_sk');
    }

    /**
     * @return HasMany
     */
    public function correctionHistoryRows() : HasMany
    {
        return $this->hasMany(CorrectionHistory::class, 'station_sk', 'station_sk');
    }

    /**
     * @return HasMany
     */
    public function weatherReliabilityRows() : HasMany
    {
        return $this->hasMany(WeatherReliability::class, 'station_sk', 'station_sk');
    }
}
