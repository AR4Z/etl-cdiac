<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class AirReliability extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'air_reliability';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['station_sk', 'date_sk'];

    protected $fillable = [
        'station_sk', 'date_sk',
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

    public function station(){
        return $this->belongsTo(StationDim::class, 'station_sk', 'station_sk');
    }

    public function date(){
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }
}
