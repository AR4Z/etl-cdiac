<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class DateDim extends Model
{

    protected $connection = 'data_warehouse';

    protected $table = 'date_dim';


    protected $fillable = [
        'fecha_sk','fecha', 'año', 'mes','dia','diasemana','semanaaño', 'trimestre', 'semestre', 'lustro', 'nombremes', 'nombredia'
    ];


}
