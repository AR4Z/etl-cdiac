<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporaryCorrection extends Model
{
    /**
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * @var string
     */
    protected $table = 'temporary_correction';

    /**
     * @var array
     */
    protected $fillable = [
        'temporary_id','station_id','date_sk', 'time_sk','variable','error_value',
        'observation', 'correct_value', 'applied_correction_type',
    ];
}
