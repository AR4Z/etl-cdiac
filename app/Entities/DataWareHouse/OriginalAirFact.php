<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class OriginalAirFact extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'original_air_fact';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['station_sk', 'date_sk', 'time_sk'];

    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'so2_local_ppt',
        'so2_local_ugm3',
        'so2_estan_ugm3',
        'co_local_ppt',
        'co_local_ugm3',
        'co_estan_ugm3',
        'o3_local_ppt',
        'o3_local_ugm3',
        'o3_estan_ugm3',
        'pm10',
        'pm2_5',
        'comment',
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
