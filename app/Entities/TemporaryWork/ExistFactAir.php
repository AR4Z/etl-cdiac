<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactAir extends Model
{
    /**
     * @var string
     */
    protected $connection = 'temporary_work';

    /**
     * @var string
     */
    protected $table = 'exist_fact_air';

    /**
     * @var array
     */
    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk','date_time',
        'so2_local_ppb',
        'so2_estan_ugm3',
        'co_local_ppb',
        'co_estan_ugm3',
        'o3_local_ppb',
        'o3_estan_ugm3',
        'pm10',
        'pm2_5',
        'pst',
        'comment',
    ];
}
