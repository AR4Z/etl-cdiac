<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TechnicalSheetFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('technical_sheet_field')->insert(
            [
                [
                    'name'          => 'Propietario',
                    'description'   => 'Entidad dueña de la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Ubicación',
                    'description'   => 'Lugar específico donde se encuentra la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Altitud',
                    'description'   => 'Altura a la cual está la estación, está dada en m.s.n.m',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Activa desde',
                    'description'   => 'Fecha de la primera trasmisión',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Corriente',
                    'description'   => 'Afluente al cual se le realiza el monitoreon',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Municipio',
                    'description'   => 'Municipio donde se encuentra ubicada la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Departamento',
                    'description'   => 'Departamento donde se encuentra ubicada la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Cuenca',
                    'description'   => 'Cuenca a la cual pertenece la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Barrio-Comuna',
                    'description'   => 'Barrio-Comuna donde se encuentra ubicada la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Subcuenca',
                    'description'   => 'Subcuenca a la cual pertenece la estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Código',
                    'description'   => 'Código de la estación que contiene identificación de departamento, municipio, dueño, tipo y número de estación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Variable medida',
                    'description'   => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Observación',
                    'description'   => '',
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
        DB::connection('administrator')->table('technical_sheet_field')->delete();
    }
}
