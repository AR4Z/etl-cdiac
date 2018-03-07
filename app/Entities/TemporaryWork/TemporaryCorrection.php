<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporaryCorrection extends Model
{
    protected $connection = 'temporary_work';

    protected $table = 'temporary_correction';

    protected $fillable = [
        'temporary_id','station_id','date_sk', 'time_sk','variable','error_value',
        'observation', 'correct_value', 'applied_correction_type',
    ];
}
