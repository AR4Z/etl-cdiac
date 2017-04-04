<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporalAir extends Model
{
    /**
     * The database TemporalWalther used by the model.
     *
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table= 'temporal_air';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','estacion_sk', 'fecha_sk', 'tiempo_sk','fecha','hora','so2', 'o3', 'co'
    ];
}
