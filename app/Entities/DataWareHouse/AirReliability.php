<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirReliability extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'air_reliability';

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
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id','station_sk', 'date_sk',
        'so2_total_records',
        'so2_correct_records',
        'so2_support',
        'so2_trust',

        'co_total_records',
        'co_correct_records',
        'co_support',
        'co_trust',

        'o3_total_records',
        'o3_correct_records',
        'o3_support',
        'o3_trust',

        'pm10_total_records',
        'pm10_correct_records',
        'pm10_support',
        'pm10_trust',

        'pm2_5_total_records',
        'pm2_5_correct_records',
        'pm2_5_support',
        'pm2_5_trust',
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
}
