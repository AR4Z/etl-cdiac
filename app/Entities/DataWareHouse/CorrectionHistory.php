<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class CorrectionHistory extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'correction_history';

    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'variable',
        'error_value',
        'observation',
        'correct_value',
        'applied_correction_type',
    ];

    public function station(){
        return $this->belongsTo(StationDim::class, 'station_sk', 'station_sk');
    }

    public function date(){
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }

    public function time(){
        return $this->belongsTo(TimeDim::class, 'time_sk', 'time_sk');
    }
}
