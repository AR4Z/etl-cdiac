<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class TimeDim extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'time_dim';


    protected $fillable = [
        'tiempo_sk','tiempo', 'horas', 'minutos','segundos','jornada'
    ];
}
