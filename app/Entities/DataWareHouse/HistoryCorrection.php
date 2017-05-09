<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class HistoryCorrection extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'history_correction';

    protected $fillable = [
        'temporary_id','estacion_sk','fecha_sk', 'tiempo_sk','variable','error_value',
        'observation', 'correct_value', 'applied_correction_type',
    ];
}
