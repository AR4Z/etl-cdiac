<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('application')->insert(
            [

                [
                    # id => 1
                    'name'                      => 'CDIAC',
                    'app_url'                   => '',
                    'description'               => 'aplicación xxxxx para xxxxx',

                ],
                [
                    # id => 2
                    'name'                      => 'Sistema de Gestión del Riesgo',
                    'app_url'                   => 'risks',
                    'description'               => 'aplicación xxxxx para xxxxx',

                ],
                [
                    # id => 3
                    'name'                      => 'Sistema de Indicadores',
                    'app_url'                   => 'indicadores',
                    'description'               => 'aplicación xxxxx para xxxxx',
                ],
                [
                    # id => 4
                    'name'                      => 'Módulo de Auditoría',
                    'app_url'                   => 'auditory',
                    'description'               => 'aplicación xxxxx para xxxxx',

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
        DB::connection('public')->table('application')->delete();
    }
}
