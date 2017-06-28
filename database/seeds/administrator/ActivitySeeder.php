<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('activity')->insert(
            [
                [
                    'name'          => 'Instalación',
                    'description'   => 'Instalación de un nuevo equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Calibración',
                    'description'   => 'Calibración de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Verificación',
                    'description'   => 'Verificación de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Pintura',
                    'description'   => 'Pintura',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Cambio',
                    'description'   => 'Cambio de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Retiro',
                    'description'   => 'Retiro de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Limpieza',
                    'description'   => 'Limpieza de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Observación',
                    'description'   => 'Observación de un equipo',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Tornillería',
                    'description'   => 'Tornillería',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
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
        DB::connection('administrator')->table('activity')->delete();
    }
}
