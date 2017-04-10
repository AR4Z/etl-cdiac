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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
          'quantity_measurement_day'  => 96,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Cumanday',
          'name_table'                => 'est_cumandai',
          'type'                      => 'Meteorológica',
          'quantity_measurement_day'  => 96,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Molinos',
          'name_table'                => 'est_molinos',
          'type'                      => 'Hidrometeorológica',
          'quantity_measurement_day'  => 96,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Nereidas',
          'name_table'                => 'est_nereidas',
          'type'                      => 'Hidrometeorológica',
          'quantity_measurement_day'  => 96,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 5,
          'name'                      => 'Río Rioclaro',
          'name_table'                => 'est_rio_claro',
          'type'                      => 'Hidrometeorológica',
          'quantity_measurement_day'  => 96,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 6,
          'name'                      => 'Cenicafé',
          'name_table'                => null,
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Solo Precipitación',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Hidrometeorológica',
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
          'type'                      => 'Meteorológica',
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
          'type'                      => 'Calidad del aire',
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
          'type'                      => 'Calidad del aire',
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
          'type'                      => 'Calidad del aire',
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
          'type'                      => 'Calidad del aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at'                => Carbon::now(),
          'updated_at'                => Carbon::now(),
        ]
      );

      DB::connection('config')->table('station')->insert(
        [
          'connection_id'             => 1,
          'name'                      => 'Milan',
          'name_table'                => null,
          'type'                      => 'Calidad del aire',
          'quantity_measurement_day'  => 288,
          'active'                    => false,
          'created_at'                => Carbon::now(),
          'updated_at'                => Carbon::now(),
        ]
      );

    }
}
