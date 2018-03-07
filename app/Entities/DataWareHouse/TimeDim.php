<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class TimeDim extends Model
{
    protected $connection = 'data_warehouse';
    
    protected $table = 'time_dim';

    protected $primaryKey = 'time_sk';

    public $timestamps = false;

    protected $fillable = [
        'time',
        'hours',
        'minutes',
        'seconds',
        'part_day',
    ];

    public function weatherRows(){
        return $this->hasMany(WeatherFact::class, 'time_sk', 'time_sk');
    }

    public function airRows(){
        return $this->hasMany(AirFact::class, 'time_sk', 'time_sk');
    }

    public function groundwaterRows(){
        return $this->hasMany(GroundwaterFact::class, 'time_sk', 'time_sk');
    }

    public function correctionHistoryRows(){
        return $this->hasMany(CorrectionHistory::class, 'time_sk', 'time_sk');
    }
}
