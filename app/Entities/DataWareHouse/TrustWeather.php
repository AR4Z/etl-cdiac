<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class TrustWeather extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'trust_weather';

    protected $fillable = [
        'id','estacion_sk','fecha_sk',
        'total_incoming_precipitacion', 'total_good_precipitacion','support_precipitacion','trust_precipitacion',
        'total_incoming_temperatura', 'total_good_temperatura','support_temperatura','trust_temperatura',
        'total_incoming_brillo', 'total_good_brillo','support_brillo','trust_brillo',
        'total_incoming_humedad_relativa', 'total_good_humedad_relativa','support_humedad_relativa','trust_humedad_relativa',
        'total_incoming_nivel', 'total_good_nivel','support_nivel','trust_nivel',
        'total_incoming_caudal', 'total_good_caudal','support_caudal','trust_caudal',
        'total_incoming_velocidad_viento', 'total_good_velocidad_viento','support_velocidad_viento','trust_velocidad_viento',
        'total_incoming_direccion_viento', 'total_good_direccion_viento','support_direccion_viento','trust_direccion_viento',
        'total_incoming_presion_barometrica', 'total_good_presion_barometrica','support_presion_barometrica','trust_presion_barometrica',
        'total_incoming_evapotranspiracion', 'total_good_evapotranspiracion','support_evapotranspiracion','trust_evapotranspiracion',
        'total_incoming_radiacion_solar', 'total_good_radiacion_solar','support_radiacion_solar','trust_radiacion_solar',
    ];
}