<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class DateDim extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'date_dim';

    protected $primaryKey = 'date_sk';

    public $timestamps = false;

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

    public function inventoryRows(){
        return $this->hasMany(InventoryFact::class, 'date_sk', 'date_sk');
    }

    public function weatherRows(){
        return $this->hasMany(WeatherFact::class, 'date_sk', 'date_sk');
    }

    public function airRows(){
        return $this->hasMany(AirFact::class, 'date_sk', 'date_sk');
    }

    public function groundwaterRows(){
        return $this->hasMany(GroundwaterFact::class, 'date_sk', 'date_sk');
    }

    public function airReliabilityRows(){
        return $this->hasMany(AirReliability::class, 'date_sk', 'date_sk');
    }

    public function correctionHistoryRows(){
        return $this->hasMany(CorrectionHistory::class, 'date_sk', 'date_sk');
    }

    public function weatherReliabilityRows(){
        return $this->hasMany(WeatherReliability::class, 'date_sk', 'date_sk');
    }
}
