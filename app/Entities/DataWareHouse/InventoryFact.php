<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class InventoryFact extends Model
{
    protected $connection = 'data_warehouse';
    
    protected $table = 'inventory_fact';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['source_sk', 'date_sk'];

    protected $fillable = [
        'source_sk', 'date_sk',
        'co',
        'nox',
        'sox',
        'pm10',
        'tsp',
        'voc',
        'metals',
        'co2',
        'ch4',
        'n2o',
        'quantity',
        'comment',
    ];

    public function source(){
        return $this->belongsTo(SourceDim::class, 'source_sk', 'source_sk');
    }

    public function date(){
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }
}
