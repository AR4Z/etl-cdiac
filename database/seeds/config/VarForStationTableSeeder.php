<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VarForStationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    // inicio de semillas para estacion 1

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 1,
          'minimum'             => 0,
          'maximum'             => 1,
          'previous_difference' => null,
          'correction_type'     =>'dato_anterior',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 2,
          'minimum'             => 0,
          'maximum'             => 360,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 4,
          'minimum'             => 630,
          'maximum'             => 642,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 5,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 7,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 8,
          'minimum'             => 0,
          'maximum'             => 100,
          'previous_difference' => 10,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 1,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 1

      // inicio de semillas para estacion 2

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 2,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 2,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 2,
          'variable_id'         => 9,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 2

      // inicio de semillas para estacion 3

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 1,
          'minimum'             => 0,
          'maximum'             => 1,
          'previous_difference' => null,
          'correction_type'     => 'dato_anterior',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 2,
          'minimum'             => 0,
          'maximum'             => 360,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 4,
          'minimum'             => 597,
          'maximum'             => 609,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 5,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 7,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 8,
          'minimum'             => 0,
          'maximum'             => 100,
          'previous_difference' => 10,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 3,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );


      // fin de semillas para estacion 3

      // inicio de semillas para estacion 4

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 1,
          'minimum'             => 0,
          'maximum'             => 1,
          'previous_difference' => null,
          'correction_type'     => 'dato_anterior',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 2,
          'minimum'             => 0,
          'maximum'             => 360,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 4,
          'minimum'             => 605,
          'maximum'             => 619,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 5,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 7,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 8,
          'minimum'             => 0,
          'maximum'             => 100,
          'previous_difference' => 10,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 4,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 4


      // inicio de semillas para estacion 5

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 1,
          'minimum'             => 0,
          'maximum'             => 1,
          'previous_difference' => null,
          'correction_type'     => 'dato_anterior',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 2,
          'minimum'             => 0,
          'maximum'             => 360,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 4,
          'minimum'             => 605,
          'maximum'             => 619,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 5,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 7,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 8,
          'minimum'             => 0,
          'maximum'             => 100,
          'previous_difference' => 10,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 5,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 5

      // inicio de semillas para estacion 6

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 6,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 6,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 6,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 6

      // inicio de semillas para estacion 7

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 7,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 7,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 7,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 7

      // inicio de semillas para estacion 8

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 8,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 8,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 8,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 8

      // inicio de semillas para estacion 9

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 9,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 9,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 9,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 9

      // inicio de semillas para estacion 10

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 10,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 10,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 10,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 10

      // inicio de semillas para estacion 11

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 11,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 11,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 11,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 11


      // inicio de semillas para estacion 12

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 12,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 12,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 12,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 12

      // inicio de semillas para estacion 13

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 13,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 13,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 13,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 13

      // inicio de semillas para estacion 14

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 14,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 14,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 14,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 14

      // inicio de semillas para estacion 15

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 15,
          'variable_id'         => 10,
          'minimum'             => 7,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 15,
          'variable_id'         => 3,
          'minimum'             => null,
          'maximum'             => null,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 15,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      // fin de semillas para estacion 15

      // inicio de semillas para estacion 16

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 1,
            'minimum'             => 0,
            'maximum'             => 1,
            'previous_difference' => null,
            'correction_type'     =>'dato_anterior',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 2,
            'minimum'             => 0,
            'maximum'             => 360,
            'previous_difference' => null,
            'correction_type'     => null,

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 4,
            'minimum'             => 596,
            'maximum'             => 610,
            'previous_difference' => null,
            'correction_type'     => 'promedio',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 5,
            'minimum'             => null,
            'maximum'             => null,
            'previous_difference' => null,
            'correction_type'     => 'promedio',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 7,
            'minimum'             => 0,
            'maximum'             => 15,
            'previous_difference' => null,
            'correction_type'     => null,

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 8,
            'minimum'             => 0,
            'maximum'             => 100,
            'previous_difference' => 10,
            'correction_type'     => 'promedio',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 9,
            'minimum'             => 0,
            'maximum'             => 15,
            'previous_difference' => null,
            'correction_type'     => 'diferencia_de_0,2',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        DB::connection('config')->table('var_for_station')->insert(
          [
            'station_id'          => 16,
            'variable_id'         => 10,
            'minimum'             => 7,
            'maximum'             => 40,
            'previous_difference' => 5,
            'correction_type'     => 'promedio',

            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
          ]
        );

        // fin de semillas para estacion 16


        // inicio de semillas para estacion 17

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 1,
              'minimum'             => 0,
              'maximum'             => 1,
              'previous_difference' => null,
              'correction_type'     =>'dato_anterior',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 2,
              'minimum'             => 0,
              'maximum'             => 360,
              'previous_difference' => null,
              'correction_type'     => null,

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 4,
              'minimum'             => 603,
              'maximum'             => 613,
              'previous_difference' => null,
              'correction_type'     => 'promedio',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 5,
              'minimum'             => null,
              'maximum'             => null,
              'previous_difference' => null,
              'correction_type'     => 'promedio',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 7,
              'minimum'             => 0,
              'maximum'             => 15,
              'previous_difference' => null,
              'correction_type'     => null,

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 8,
              'minimum'             => 0,
              'maximum'             => 100,
              'previous_difference' => 10,
              'correction_type'     => 'promedio',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 9,
              'minimum'             => 0,
              'maximum'             => 15,
              'previous_difference' => null,
              'correction_type'     => 'diferencia_de_0,2',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          DB::connection('config')->table('var_for_station')->insert(
            [
              'station_id'          => 17,
              'variable_id'         => 10,
              'minimum'             => 7,
              'maximum'             => 40,
              'previous_difference' => 5,
              'correction_type'     => 'promedio',

              'created_at'          => Carbon::now(),
              'updated_at'          => Carbon::now(),
            ]
          );

          // fin de semillas para estacion 17

          // inicio de semillas para estacion 18

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 1,
                'minimum'             => 0,
                'maximum'             => 1,
                'previous_difference' => null,
                'correction_type'     =>'dato_anterior',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 2,
                'minimum'             => 0,
                'maximum'             => 360,
                'previous_difference' => null,
                'correction_type'     => null,

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 4,
                'minimum'             => 595,
                'maximum'             => 610,
                'previous_difference' => null,
                'correction_type'     => 'promedio',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 5,
                'minimum'             => 0,
                'maximum'             => 1600,
                'previous_difference' => null,
                'correction_type'     => 'promedio',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 7,
                'minimum'             => 0,
                'maximum'             => 15,
                'previous_difference' => null,
                'correction_type'     => null,

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 8,
                'minimum'             => 0,
                'maximum'             => 100,
                'previous_difference' => 10,
                'correction_type'     => 'promedio',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 9,
                'minimum'             => 0,
                'maximum'             => 15,
                'previous_difference' => null,
                'correction_type'     => 'diferencia_de_0,2',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            DB::connection('config')->table('var_for_station')->insert(
              [
                'station_id'          => 18,
                'variable_id'         => 10,
                'minimum'             => 5,
                'maximum'             => 40,
                'previous_difference' => 5,
                'correction_type'     => 'promedio',

                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
              ]
            );

            // fin de semillas para estacion 18

            // inicio de semillas para estacion 19

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 1,
                  'minimum'             => 0,
                  'maximum'             => 1,
                  'previous_difference' => null,
                  'correction_type'     =>'dato_anterior',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 2,
                  'minimum'             => 0,
                  'maximum'             => 360,
                  'previous_difference' => null,
                  'correction_type'     => null,

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 4,
                  'minimum'             => 600,
                  'maximum'             => 620,
                  'previous_difference' => null,
                  'correction_type'     => 'promedio',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 5,
                  'minimum'             => 0,
                  'maximum'             => 1600,
                  'previous_difference' => null,
                  'correction_type'     => 'promedio',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 7,
                  'minimum'             => 0,
                  'maximum'             => 15,
                  'previous_difference' => null,
                  'correction_type'     => null,

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 8,
                  'minimum'             => 0,
                  'maximum'             => 100,
                  'previous_difference' => 10,
                  'correction_type'     => 'promedio',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 9,
                  'minimum'             => 0,
                  'maximum'             => 15,
                  'previous_difference' => null,
                  'correction_type'     => 'diferencia_de_0,2',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              DB::connection('config')->table('var_for_station')->insert(
                [
                  'station_id'          => 19,
                  'variable_id'         => 10,
                  'minimum'             => 5,
                  'maximum'             => 40,
                  'previous_difference' => 5,
                  'correction_type'     => 'promedio',

                  'created_at'          => Carbon::now(),
                  'updated_at'          => Carbon::now(),
                ]
              );

              // fin de semillas para estacion 19

              // inicio de semillas para estacion 20

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 1,
                    'minimum'             => 0,
                    'maximum'             => 1,
                    'previous_difference' => null,
                    'correction_type'     =>'dato_anterior',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 2,
                    'minimum'             => 0,
                    'maximum'             => 360,
                    'previous_difference' => null,
                    'correction_type'     => null,

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 4,
                    'minimum'             => 580,
                    'maximum'             => 600,
                    'previous_difference' => null,
                    'correction_type'     => 'promedio',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 5,
                    'minimum'             => 0,
                    'maximum'             => 1600,
                    'previous_difference' => null,
                    'correction_type'     => 'promedio',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 7,
                    'minimum'             => 0,
                    'maximum'             => 15,
                    'previous_difference' => null,
                    'correction_type'     => null,

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 8,
                    'minimum'             => 0,
                    'maximum'             => 100,
                    'previous_difference' => 10,
                    'correction_type'     => 'promedio',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 9,
                    'minimum'             => 0,
                    'maximum'             => 15,
                    'previous_difference' => null,
                    'correction_type'     => 'diferencia_de_0,2',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                DB::connection('config')->table('var_for_station')->insert(
                  [
                    'station_id'          => 20,
                    'variable_id'         => 10,
                    'minimum'             => 5,
                    'maximum'             => 40,
                    'previous_difference' => 5,
                    'correction_type'     => 'promedio',

                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                  ]
                );

                // fin de semillas para estacion 20

  // inicio de semillas para estacion 21

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
                      'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 4,
        'minimum'             => 600,
        'maximum'             => 620,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 21,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    // fin de semillas para estacion 21


    // inicio de semillas para estacion 22

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 1,
          'minimum'             => 0,
          'maximum'             => 1,
          'previous_difference' => null,
          'correction_type'     =>'dato_anterior',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 2,
          'minimum'             => 0,
          'maximum'             => 360,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
          ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 4,
          'minimum'             => 586,
          'maximum'             => 620,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 5,
          'minimum'             => 0,
          'maximum'             => 1600,
          'previous_difference' => null,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 7,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => null,

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 8,
          'minimum'             => 0,
          'maximum'             => 100,
          'previous_difference' => 10,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 9,
          'minimum'             => 0,
          'maximum'             => 15,
          'previous_difference' => null,
          'correction_type'     => 'diferencia_de_0,2',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

      DB::connection('config')->table('var_for_station')->insert(
        [
          'station_id'          => 22,
          'variable_id'         => 10,
          'minimum'             => 0,
          'maximum'             => 40,
          'previous_difference' => 5,
          'correction_type'     => 'promedio',

          'created_at'          => Carbon::now(),
          'updated_at'          => Carbon::now(),
        ]
      );

  // fin de semillas para estacion 22

  // inicio de semillas para estacion 23

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 4,
        'minimum'             => 586,
        'maximum'             => 620,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 23,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 23

  // inicio de semillas para estacion 24

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 4,
        'minimum'             => 595,
        'maximum'             => 615,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 24,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 24

  // inicio de semillas para estacion 25

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 4,
        'minimum'             => 585,
        'maximum'             => 610,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 25,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 25

  // inicio de semillas para estacion 26

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 4,
        'minimum'             => 585,
        'maximum'             => 596,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 26,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 26

  // inicio de semillas para estacion 27

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 4,
        'minimum'             => 598,
        'maximum'             => 620,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 27,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 27

  // inicio de semillas para estacion 28

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 4,
        'minimum'             => 580,
        'maximum'             => 600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 28,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 28


  // inicio de semillas para estacion 29

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 4,
        'minimum'             => 585,
        'maximum'             => 600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 29,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 29


  // inicio de semillas para estacion 30

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 30,
      'variable_id'         => 6,
      'minimum'             => 0,
      'maximum'             => 1200,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 30,
      'variable_id'         => 3,
      'minimum'             => 1.5,
      'maximum'             => 250,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 30,
      'variable_id'         => 9,
      'minimum'             => 0,
      'maximum'             => 15,
      'previous_difference' => null,
      'correction_type'     => 'diferencia_de_0,2',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 30,
      'variable_id'         => 10,
      'minimum'             => 0,
      'maximum'             => 40,
      'previous_difference' => 5,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 30

  // inicio de semillas para estacion 31

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 1,
        'minimum'             => 0,
        'maximum'             => 1,
        'previous_difference' => null,
        'correction_type'     =>'dato_anterior',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 2,
        'minimum'             => 0,
        'maximum'             => 360,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
        ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 4,
        'minimum'             => 580,
        'maximum'             => 600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 5,
        'minimum'             => 0,
        'maximum'             => 1600,
        'previous_difference' => null,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 7,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => null,

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 8,
        'minimum'             => 0,
        'maximum'             => 100,
        'previous_difference' => 10,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 9,
        'minimum'             => 0,
        'maximum'             => 15,
        'previous_difference' => null,
        'correction_type'     => 'diferencia_de_0,2',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

    DB::connection('config')->table('var_for_station')->insert(
      [
        'station_id'          => 31,
        'variable_id'         => 10,
        'minimum'             => 0,
        'maximum'             => 40,
        'previous_difference' => 5,
        'correction_type'     => 'promedio',

        'created_at'          => Carbon::now(),
        'updated_at'          => Carbon::now(),
      ]
    );

  // fin de semillas para estacion 31


  // inicio de semillas para estacion 32

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 2,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 4,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 5,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 7,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 8,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 9,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 32,
      'variable_id'         => 10,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 32


  // inicio de semillas para estacion 33

    // TUDO Cumanday

  // fin de semillas para estacion 33



  // inicio de semillas para estacion 34

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 34,
      'variable_id'         => 3,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );


  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 34,
      'variable_id'         => 6,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 34,
      'variable_id'         => 9,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 34,
      'variable_id'         => 10,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 34

  // inicio de semillas para estacion 35

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 35,
      'variable_id'         => 3,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );


  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 35,
      'variable_id'         => 6,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 35,
      'variable_id'         => 9,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 35,
      'variable_id'         => 10,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 35

  // inicio de semillas para estacion 36

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 36,
      'variable_id'         => 3,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );


  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 36,
      'variable_id'         => 6,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 36,
      'variable_id'         => 9,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 36,
      'variable_id'         => 10,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 36

  // inicio de semillas para estacion 61

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 61,
      'variable_id'         => 3,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 61,
      'variable_id'         => 5,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 61,
      'variable_id'         => 10,
      'minimum'             => 0,
      'maximum'             => 15,
      'previous_difference' => null,
      'correction_type'     => 'diferencia_de_0,2',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );



  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 61,
      'variable_id'         => 10,
      'minimum'             => 7,
      'maximum'             => 40,
      'previous_difference' => 5,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 61

  // inicio de semillas para estacion 62

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 62,
      'variable_id'         => 5,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 62,
      'variable_id'         => 10,
      'minimum'             => 0,
      'maximum'             => 15,
      'previous_difference' => null,
      'correction_type'     => 'diferencia_de_0,2',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );



  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 62,
      'variable_id'         => 10,
      'minimum'             => 7,
      'maximum'             => 40,
      'previous_difference' => 5,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 62

  // inicio de semillas para estacion 63

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 63,
      'variable_id'         => 5,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 63,
      'variable_id'         => 10,
      'minimum'             => 0,
      'maximum'             => 15,
      'previous_difference' => null,
      'correction_type'     => 'diferencia_de_0,2',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 63,
      'variable_id'         => 10,
      'minimum'             => 7,
      'maximum'             => 40,
      'previous_difference' => 5,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 63


  // inicio de semillas para estacion 77

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 77,
      'variable_id'         => 15,
      'minimum'             => 0,
      'maximum'             => 50000,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 77,
      'variable_id'         => 13,
      'minimum'             => 0,
      'maximum'             => 500,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 77,
      'variable_id'         => 11,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 77,
      'variable_id'         => 12,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => 'promedio',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 77,
      'variable_id'         => 14,
      'minimum'             => 0,
      'maximum'             => 400,
      'previous_difference' => null,
      'correction_type'     => 'a_cero',

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );
  // fin de semillas para estacion 77

  // inicio de semillas para estacion 78

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 78,
      'variable_id'         => 11,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 78


  // inicio de semillas para estacion 79

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 79,
      'variable_id'         => 11,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 79

  // inicio de semillas para estacion 80

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 80,
      'variable_id'         => 11,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 80

  // inicio de semillas para estacion 81

  DB::connection('config')->table('var_for_station')->insert(
    [
      'station_id'          => 81,
      'variable_id'         => 11,
      'minimum'             => null,
      'maximum'             => null,
      'previous_difference' => null,
      'correction_type'     => null,

      'created_at'          => Carbon::now(),
      'updated_at'          => Carbon::now(),
    ]
  );

  // fin de semillas para estacion 81

  }
}
