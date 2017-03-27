<?php

namespace App\Entities\TemporaryWork;

use Illuminate\Database\Eloquent\Model;

class TemporalWeather extends Model
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
    protected $table= 'temporal_weather';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','estacion_sk', 'fecha_sk', 'tiempo_sk','fecha','hora','precipitacion', 'temperatura',
        'brillo', 'humedad_relativa', 'nivel', 'caudal', 'velocidad_viento', 'direccion_viento',
        'presion_barometrica', 'evapotranspiracion', 'radiacion_solar', 'observaciones'
    ];
}
