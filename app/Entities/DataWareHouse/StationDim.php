<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class StationDim extends Model
{
    protected $connection = 'data_warehouse';
    
    protected $table = 'station_dim';

    protected $primaryKey = 'station_sk';

    public $timestamps = false;

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

    public function weatherRows(){
        return $this->hasMany(WeatherFact::class, 'station_sk', 'station_sk');
    }

    public function airRows(){
        return $this->hasMany(AirFact::class, 'station_sk', 'station_sk');
    }

    public function groundwaterRows(){
        return $this->hasMany(GroundwaterFact::class, 'station_sk', 'station_sk');
    }

    public function airReliabilityRows(){
        return $this->hasMany(AirReliability::class, 'station_sk', 'station_sk');
    }

    public function correctionHistoryRows(){
        return $this->hasMany(CorrectionHistory::class, 'station_sk', 'station_sk');
    }

    public function weatherReliabilityRows(){
        return $this->hasMany(WeatherReliability::class, 'station_sk', 'station_sk');
    }
}
