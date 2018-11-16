<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRainfallFact extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'event_rainfall_fact';

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
        'station_sk',
        'date_sk',
        'time_sk',
        'date_time',
        'duration',
        'magnitude',
        'intensity',
        'primary_betas',
        'index_n',
        'classification_lkp',
        'classification_aemet',
        'classification_moncho',
        'classification_idea',
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