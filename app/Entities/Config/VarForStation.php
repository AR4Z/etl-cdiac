<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VarForStation extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'config';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table= 'var_for_station';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','station_id', 'variable_id', 'maximum','minimum','correction_type'
    ];

    /**
     * @return BelongsTo
     */
    public function variable() : BelongsTo
    {
        return $this->belongsTo('App\Entities\Config\Variable', 'variable_id');
    }

    /**
     * @return BelongsTo
     */
    public function station() : BelongsTo
    {
        return $this->belongsTo('App\Entities\Config\Station', 'station_id');
    }
}
