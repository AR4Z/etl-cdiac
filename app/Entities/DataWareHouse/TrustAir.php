<?php

namespace App\Entities\DataWareHouse;

use Illuminate\Database\Eloquent\Model;

class TrustAir extends Model
{
    protected $connection = 'data_warehouse';

    protected $table = 'trust_air';

    protected $fillable = [
        'estacion_sk','fecha_sk',
        'total_incoming_s02', 'total_good_s02','support_s02','trust_s02',
        'total_incoming_co', 'total_good_co','support_co','trust_co',
        'total_incoming_o3', 'total_good_o3','support_o3','trust_o3',
        'total_incoming_pm10', 'total_good_pm10','support_pm10','trust_pm10',
        'total_incoming_pm2_5', 'total_good_pm2_5','support_pm2_5','trust_pm2_5',
    ];
}
