<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactAir extends Model
{
    protected $connection = 'temporary_work';

    protected $table = 'exist_fact_aire';

    protected $fillable = [
        'estacion_sk','fecha_sk', 'tiempo_sk', 'so2_local_ppt','so2_local_ppt','so2_local_ugm3','so2_estan_ugm3',
        'co_local_ppt', 'co_local_ugm3', 'co_estan_ugm3','o3_local_ppt', 'o3_local_ugm3', 'o3_estan_ugm3','pm10','pm2_5'
    ];
}
