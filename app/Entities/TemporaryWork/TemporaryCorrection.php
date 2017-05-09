<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporaryCorrection extends Model
{
    protected $connection = 'temporary_work';

    protected $table = 'temporary_correction';

    protected $fillable = [
        'temporary_id','estacion_sk','fecha_sk', 'tiempo_sk','variable','error_value',
        'observation', 'correct_value', 'applied_correction_type',
    ];
}
