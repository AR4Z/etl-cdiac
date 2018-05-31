<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactAir extends Model
{
    protected $connection = 'temporary_work';

    protected $table = 'exist_fact_air';

    protected $fillable = [
        'station_sk', 'date_sk', 'time_sk',
        'so2_local_ppb',
        'so2_local_ugm3',
        'so2_estan_ugm3',
        'co_local_ppb',
        'co_local_ugm3',
        'co_estan_ugm3',
        'o3_local_ppb',
        'o3_local_ugm3',
        'o3_estan_ugm3',
        'pm10',
        'pm2_5',
        'pst',
        'comment',
    ];
}
