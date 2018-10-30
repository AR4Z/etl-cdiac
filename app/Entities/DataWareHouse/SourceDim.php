<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SourceDim extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'source_dim';

    /**
     * @var string
     */
    protected $primaryKey = 'source_sk';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'source_type',
        'name',
    ];

    /**
     * @return HasMany
     */
    public function inventoryRows() : HasMany
    {
        return $this->hasMany(InventoryFact::class, 'source_sk', 'source_sk');
    }
}
