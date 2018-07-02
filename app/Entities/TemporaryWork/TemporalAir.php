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
        'station_sk', 'date_sk', 'time_sk', 'date_time',
        'date','time',
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
