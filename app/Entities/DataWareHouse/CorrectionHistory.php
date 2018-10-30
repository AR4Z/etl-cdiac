<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectionHistory extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'correction_history';

    /**
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'variable',
        'error_value',
        'observation',
        'correct_value',
        'applied_correction_type',
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
