<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('station_type')->insert(
            [
                [
                    #id 1
                    'name'          => 'Meteorológica',
                    'code'          => 'M',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación encargada de medir variables asociadas a la atmósfera, como temperatura del aire, precipitación, entre otros',
                    'report_name'    => 'reporteEstacionMeteoro.php',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 2
                    'name'          => 'Hidrometeorológica',
                    'code'          => 'H',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación que registra datos asociados a corrientes de agua, como el nivel y caudal, y además monitorea variables asociadas a la atmósfera, en este caso, precipitación y temperatura.',
                    'report_name'    => 'reporteEstacionHidro.php',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 3
                    'name'          => 'Repetidora',
                    'code'          => 'R',
                    'etl_method'    => null,
                    'description'   => 'Estación encargada de generar el puente de comunicación con estaciones que se encuentran a mucha distancia de la central de acopio de la información, y no pueden enviar sus datos punto a punto.',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 4
                    'name'          => 'Alarma Sonora',
                    'code'          => 'AS',
                    'etl_method'    => null,
                    'description'   => 'Estación que emite mensajes de audio pregrabados por medio de bocinas o cornetas y voces de alerta mediante sirenas a la comunidad.',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 5
                    'name'          => 'Alerta',
                    'code'          => 'A',
                    'etl_method'    => null,
                    'description'   => 'Estación que permite administrar las estaciones de alarma sonora de los SAT asociados a una cuenca o corriente específica y generar las activaciones de las voces de alerta a la comunidad de manera remota.',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 6
                    'name'          => 'Central',
                    'code'          => 'C',
                    'etl_method'    => null,
                    'description'   => 'Estación que se encarga de la recepción, almacenamiento y exportación de datos a formatos convencionalmente utilizados para visualizarlos.',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 7
                    'name'          => 'Calidad del aire',
                    'code'          => 'CA',
                    'etl_method'    => 'air',
                    'description'   => 'Estación que mide la calidad del aire con variables como partículas contaminante, co2, entre otras.',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 8
                    'name'          => 'Meteorológica movil',
                    'code'          => 'MM',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación meteorológica móvil',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 9
                    'name'          => 'Calidad del agua',
                    'code'          => 'CAG',
                    'etl_method'    => null,
                    'description'   => 'Estación de calidad del agua',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 10
                    'name'          => 'Sismológica',
                    'code'          => 'SI',
                    'etl_method'    => null,
                    'description'   => 'Estación sismológica',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 11
                    'name'          => 'Freatimétrica',
                    'code'          => 'F',
                    'etl_method'    => 'groundwater',
                    'description'   => 'Estación freatimétrica',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 12
                    'name'          => 'Suelo',
                    'code'          => 'SU',
                    'etl_method'    => null,
                    'description'   => 'Estación suelo',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 13
                    'name'          => 'Principal',
                    'code'          => 'PP',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación principal',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 15
                    'name'          => 'Pluviométrica',
                    'code'          => 'PM',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación pluviométrica',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 16
                    'name'          => 'Pluviográfica',
                    'code'          => 'PG',
                    'etl_method'    => 'weather',
                    'description'   => 'Estación pluviográfica',
                    'report_name'   => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    #id 17
                    'name'          => 'Aguas Freáticas',
                    'code'          => 'AF',
                    'etl_method'    => 'groundwater',
                    'description'   => 'Estación de Aguas Freáticas',
                    'report_name'   => null,
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
        DB::connection('administrator')->table('station_type')->delete();
    }
}
