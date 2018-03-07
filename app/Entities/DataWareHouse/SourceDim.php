<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class SourceDim extends Model
{
    protected $connection = 'data_warehouse';
    
    protected $table = 'source_dim';

    protected $primaryKey = 'source_sk';

    public $timestamps = false;

    protected $fillable = [
        'source_type',
        'name',
    ];

    public function inventoryRows(){
        return $this->hasMany(InventoryFact::class, 'source_sk', 'source_sk');
    }
}
