<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryFact extends Model
{
    /**
     * @var string
     */
    protected $connection = 'data_warehouse';

    /**
     * @var string
     */
    protected $table = 'inventory_fact';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'source_sk';

    /**
     * @var array
     */
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

    /**
     * @return BelongsTo
     */
    public function source() : BelongsTo
    {
        return $this->belongsTo(SourceDim::class, 'source_sk', 'source_sk');
    }

    /**
     * @return BelongsTo
     */
    public function date() : BelongsTo
    {
        return $this->belongsTo(DateDim::class, 'date_sk', 'date_sk');
    }
}
