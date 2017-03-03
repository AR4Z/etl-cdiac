<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Alcaldía de Marquetalia',
          'name_table'                => 'est_marquetalia',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Camping La Palmera - Río Risaralda',
          'name_table'                => 'est_risaralda',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Hogares Juveniles Campesinos - Neira',
          'name_table'                => 'est_neira',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Hospital de Villamaría',
          'name_table'                => 'est_hospivilla',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Marulanda - El Páramo',
          'name_table'                => 'est_marulanda',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Quebrada Manizales - Tesorito',
          'name_table'                => 'est_qmanizales',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Quebrada Olivares - El Popal',
          'name_table'                => 'est_olivares',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Guacaica - CHEC',
          'name_table'                => 'est_guacaica_chec',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Guacaica - Los Naranjos',
          'name_table'                => 'est_guacaica_naranjos',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Pensilvania - Microcentral',
          'name_table'                => 'est_pensilvania',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Pozo - Vía Pacora La Merced',
          'name_table'                => 'est_riopozo',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Rioclaro',
          'name_table'                => 'est_rioclaro',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Santo Domingo - Los Naranjos',
          'name_table'                => 'est_santodomingo',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Supía - Los Piononos',
          'name_table'                => 'est_supia2',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Supía - Pueblo',
          'name_table'                => 'est_supia',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Salamina - CHEC',
          'name_table'                => 'est_salamina',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Viejo Basurero de Manzanares',
          'name_table'                => 'est_manzanares',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Alcázares',
          'name_table'                => 'est_alcazares',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Aranjuez',
          'name_table'                => 'est_aranjuez',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Bosques del Norte',
          'name_table'                => 'est_bosques',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'CHEC Uribe',
          'name_table'                => 'est_chec',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'El Carmen',
          'name_table'                => 'est_carmen',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Emas',
          'name_table'                => 'est_emas',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Enea',
          'name_table'                => 'est_enea',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Hospital de Caldas',
          'name_table'                => 'est_hospital',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Ingeominas',
          'name_table'                => 'est_ingeominas',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'La Palma',
          'name_table'                => 'est_palma',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Niza',
          'name_table'                => 'est_niza',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Posgrados',
          'name_table'                => 'est_posgrados',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Quebrada San Luis - Ruta 30',
          'name_table'                => 'est_ruta',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 4,
          'name'                      => 'Yarumos',
          'name_table'                => 'est_yarumos',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Cisne - Santa Isabel',
          'name_table'                => 'est_cisne',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => '96',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Cumanday',
          'name_table'                => 'est_cumandai',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => '96',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Molinos',
          'name_table'                => 'est_molinos',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => '96',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Nereidas',
          'name_table'                => 'est_nereidas',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => '96',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Río Rioclaro',
          'name_table'                => 'est_rio_claro',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => '96',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Cenicafé',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Divisa',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Francia',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Romelia',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Sierra',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Los Pomos',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Moravo',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Naranjal',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Agronomía',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Almacafé Letras',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Java',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Flora',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Selva',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Las Colinas',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Planalto',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Santa Teresa',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Santa Teresita',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'El Recreo',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Granja Luker',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Argentina',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'La Margarita',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Santa Ana',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Santagueda',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 1,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Totuí',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Doña Juana',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Pácora',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Río Tapias',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT San Francisco',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT La Estrella',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Esmeralda',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Campoalegre',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Montevideo',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Municipal',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Sancancio',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 2,
          'name'                      => 'S.BT Guacaica',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 3,
          'name'                      => 'Cenicafé Udeger',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 3,
          'name'                      => 'El Bosque',
          'name_table'                => null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 3,
          'name'                      => 'La Batea',
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 3,
          'name'                      => 'Jardines',
          'name_table'                =>  null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Liceo',
          'name_table'                =>  null,
          'type'                      => 'Clima',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Gobernación',
          'name_table'                =>  null,
          'type'                      => 'Aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'UN Palogrande',
          'name_table'                => null,
          'type'                      => 'Aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'UN Nubia',
          'name_table'                => null,
          'type'                      => 'Aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Liceo',
          'name_table'                => null,
          'type'                      => 'Aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Milan',
          'name_table'                => null,
          'type'                      => 'Aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

    }
}
