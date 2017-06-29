<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'evapotranspiracion',

          'name_excel'      => ' Evapotranspiracion(mm)                                                                             ',

          'name_database'   => 'evapo_real',

          'name_locale'     => 'evapotranspiracion',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'direccion_viento',

          'name_excel'      => ' Direccion(º)                                                                                       ',

          'name_database'   => 'direccion',

          'name_locale'     => 'direccion_viento',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'nivel',

          'name_excel'      => 'Nivel (m)                                                                                           ',

          'name_database'   => 'nivel',

          'name_locale'     => 'nivel',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'presion_barometrica',

          'name_excel'      => ' Presion(mmHg)                                                                                      ',

          'name_database'   => 'presion',

          'name_locale'     => 'presion_barometrica',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'radiacion_solar',

          'name_excel'      => ' Radiacion(W/m^2)                                                                                   ',

          'name_database'   => 'radiacion',

          'name_locale'     => 'radiacion_solar',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'caudal',

          'name_excel'      => 'Caudal (l/s)                                                                                        ',

          'name_database'   => 'caudal',

          'name_locale'     => 'caudal',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'velocidad_viento',

          'name_excel'      => ' Velocidad(m/s)                                                                                     ',

          'name_database'   => 'velocidad',

          'name_locale'     => 'velocidad_viento',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'humedad_relativa',

          'name_excel'      => ' Humedad(%)                                                                                         ',

          'name_database'   => 'humedad',

          'name_locale'     => 'humedad_relativa',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'precipitacion',

          'name_excel'      => ' Precipitacion(mm)                                                                                  ',

          'name_database'   => 'precipitacion_real',

          'name_locale'     => 'precipitacion',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'temperatura',

          'name_excel'      => ' Temperatura(ºC)                                                                                    ',

          'name_database'   => 'temperatura',

          'name_locale'     => 'temperatura',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'PM10',

          'name_excel'      => null,

          'name_database'   => null,

          'name_locale'     => 'pm10',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'pm2_5',

          'name_excel'      => null,

          'name_database'   => null,

          'name_locale'     => 'pm2_5',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'o3',

          'name_excel'      => null,

          'name_database'   => null,

          'name_locale'     => 'o3_local_ppt',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'so2',

          'name_excel'      => null,

          'name_database'   => null,

          'name_locale'     => 'so2_local_ppt',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

      DB::connection('config')->table('variable')->insert(
        [
          'name'            => 'co',

          'name_excel'      => null,

          'name_database'   => null,

          'name_locale'     => 'co_local_ppt',

          'created_at'      => Carbon::now(),
          'updated_at'      => Carbon::now(),
        ]
      );

    }
}
