<?php

use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('alert')->insert(
            [
                [
                    # id => 1
                    'name'          => 'Alerta por deslizamientos',
                    'code'          => 'alert-a25',
                    'description'   => 'El Alerta por deslizamientos se calcula en base al indicador a25',
                    'icon'          => 'station-marker.svg',
                    'active'        => true,
                ],
                [
                    # id => 2
                    'name'          => 'Alerta por Inundación',
                    'code'          => 'alert-a10',
                    'icon'          => 'station-marker.svg',
                    'description'   => 'El Alerta por Inundación se calcula en a la precipitacion acumulada en una ventana de 10 minutos',
                    'active'        => true,
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
        DB::connection('administrator')->table('alert')->delete();
    }
}
