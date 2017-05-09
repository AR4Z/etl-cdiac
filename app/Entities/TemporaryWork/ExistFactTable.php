<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class ExistFactTable extends Model
{

    protected $connection = 'temporary_work';

    protected $table = 'exist_fact_table';

    protected $fillable = [
        'estacion_sk','fecha_sk', 'tiempo_sk', 'precipitacion','temperatura','temperatura_max','temperatura_min', 'temperatura_med', 'brillo',
        'humedad_relativa','nivel', 'caudal', 'velocidad_viento','direccion_viento','presion_barometrica','evapotranspiracion', 'radiacion_solar'
    ];
}
