<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class StationDim extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'station_dim';


    protected $fillable = [
        'estacion_sk','estacion', 'red', 'tipologia','municipio','ubicacion','latitud', 'longitud', 'altitud', 'propietario',
        'inicio_funcionamiento','fin_funcionamiento', 'observacion', 'cuenca','subcuenca','visible'
    ];
}
