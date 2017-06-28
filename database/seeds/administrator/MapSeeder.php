<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('map')->insert(
            [
                [
                    'name'                          => 'map',
                    'description'                   => 'Registros meteorológicos e hidrometeorológicos en tiempo real y registros históricos de calidad del aire obtenidos en las estaciones ubicadas en puntos estratégicos de Manizales y otros municipios del departamento de Caldas. Para mayor información de cada estación, haga click sobre los íconos correspondientes. La información mostrada se encuentra sujeta a verificación. <font color="#FF0000">¡Léase con cuidado!</font>',
                    'initial_zoom'                  => 10,
                    'initial_latitude_degrees'      => 5,
                    'initial_latitude_minutes'      => 9,
                    'initial_latitude_seconds'      => 28.8,
                    'center_latitude_direction'     => 'N',
                    'center_longitude_degrees'      => 75,
                    'center_longitude_minutes'      => 23,
                    'center_longitude_seconds'      => 37.319,
                    'center_longitude_direction'    => 'W',
                    'rt_active'                     => true,
                     'created_at'                   => Carbon::now(),
                    'updated_at'                    => Carbon::now(),
                ]
            ]
        );
    }

    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('administrator')->table('map')->delete();
    }
}
