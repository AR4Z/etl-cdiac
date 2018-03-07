<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('variable')->insert(
            [
                [
                    'name'                  => 'Precipitación',
                    'description'           => 'Productos liquidos o sólidos de la condensación de vapor de agua que caen de las nebes o son depositados desde el aire sobre la tierra. La cantidad total de precipitación que llega al suelo en un periodo determinado se expresa en términos de la profundidad.',
                    'excel_name'            => 'precipitacion',
                    'database_field_name'   => 'precipitacion_real',
                    'local_name'            => 'rainfall',
                    'decimal_precision'     => 1,
                    'unit'                  => 'mm',
                    'correct_serialization' => 'sum',
                    'report_name'           => 'reportePrecipitacion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Temperatura del aire',
                    'description'           => 'Es la magnitud física que se caracteriza por el movimiento aleatorio medio de las moléculas en un cuerpo físico.',
                    'excel_name'            => 'temperatura',
                    'database_field_name'   => 'temperatura',
                    'local_name'            => 'temperature',
                    'decimal_precision'     => 1,
                    'unit'                  => '°C',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteTemperatura.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Humedad Relativa',
                    'description'           => 'Es la relación porcentual entre la cantidad de vapor de agua que tiene el aire y el máximo que podría contener a una temperatura y presión determinada',
                    'excel_name'            => 'humedad_relativa',
                    'database_field_name'   => 'humedad',
                    'local_name'            => 'relative_humidity',
                    'decimal_precision'     => 0,
                    'unit'                  => '%',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteHumedad.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Velocidad del Viento',
                    'description'           => 'Es la relación de la distancia recorrida por el aire con respecto del tiempo empleado en recorrerla',
                    'excel_name'            => 'velocidad_viento',
                    'database_field_name'   => 'velocidad',
                    'local_name'            => 'wind_speed',
                    'decimal_precision'     => 1,
                    'unit'                  => 'm/s',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteVelocidadViento.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Dirección del Viento',
                    'description'           => 'Está definida por el punto del horizonte del observador desde el cual el viento sopla. En la actualidad, se usa internacionalmente la rosa de vientos dividida en 360°',
                    'excel_name'            => 'direccion_viento',
                    'database_field_name'   => 'direccion',
                    'local_name'            => 'wind_direction',
                    'decimal_precision'     => 0,
                    'unit'                  => '°',
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Presión Barométrica',
                    'description'           => 'Es la presión que ejerce la atmósfera que rodea la tierra sobre todos los objetos que se hallan en contacto con ella. Es un elemnto climático cuya existencia se debe a la presencia de la masa atmosférica, varía en forma temporal y espacial',
                    'excel_name'            => 'presion_barometrica',
                    'database_field_name'   => 'presion',
                    'local_name'            => 'barometric_pressure',
                    'decimal_precision'     => 1,
                    'unit'                  => 'HPa',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reportePresion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Radiación Solar',
                    'description'           => 'Es la energía emitida por el sol, que se propaga en todas las direcciones a través del espacio mediante ondas electromagnéticas. Esta energía es el motor que determina la dinámica de los procesos atmosféricos y el clima',
                    'excel_name'            => 'radiacion_solar',
                    'database_field_name'   => 'radiacion',
                    'local_name'            => 'solar_radiation',
                    'decimal_precision'     => 0,
                    'unit'                  => 'W/m2',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteRadiacion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Evapotranspiración',
                    'description'           => 'Se define como la pérdida de humedad de una superficie por evaporación directa junto con la pérdida de agua por transpiración de la vegetación',
                    'excel_name'            => 'evapotranspiracion',
                    'database_field_name'   => 'evapo_real',
                    'local_name'            => 'evapotranspiration',
                    'decimal_precision'     => 1,
                    'unit'                  => 'mm',
                    'correct_serialization' => 'sum',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Nivel',
                    'description'           => 'Es la altura desde el fondo de una corriente hasta la lámina de agua',
                    'excel_name'            => 'nivel',
                    'database_field_name'   => 'nivel',
                    'local_name'            => 'water_level',
                    'decimal_precision'     => 1,
                    'unit'                  => 'cm',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteNivel.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Caudal',
                    'description'           => 'Es la cantidad de fluido que pasa en una unidad de tiempo. Normalmente se identifica con el flujo volumétrico o volumen que pasa por un área dada en la unidad de tiempo',
                    'excel_name'            => 'caudal',
                    'database_field_name'   => 'caudal',
                    'local_name'            => 'flow_rate',
                    'decimal_precision'     => 4,
                    'unit'                  => 'm3/s',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteCaudal.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Nivel sobrante',
                    'description'           => 'nivel para estaciones Red Bocatomas CHEC',
                    'excel_name'            => 'nivel',
                    'database_field_name'   => 'nivel',
                    'local_name'            => 'water_level',
                    'decimal_precision'     => 1,
                    'unit'                  => 'cm',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteNivel.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Caudal sobrante',
                    'description'           => 'Caudal para las estaciones de la Red Bocatomas CHEC',
                    'excel_name'            => 'caudal',
                    'database_field_name'   => 'caudal',
                    'local_name'            => 'flow_rate',
                    'decimal_precision'     => 4,
                    'unit'                  => 'm3/s',
                    'correct_serialization' => 'average',
                    'report_name'           => 'reporteCaudal.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Estado alarma',
                    'description'           => null,
                    'excel_name'            => 'estado_alarma',
                    'database_field_name'   => 'estado_Alarma',
                    'local_name'            => null,
                    'decimal_precision'     => 0,
                    'unit'                  => null,
                    'correct_serialization' => null,
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'PM10',
                    'description'           => 'Material particulado 10',
                    'excel_name'            => 'pm10',
                    'database_field_name'   => null,
                    'local_name'            => 'pm10',
                    'decimal_precision'     => 2,
                    'unit'                  => 'µg/m3',
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'pm2_5',
                    'description'           => null,
                    'excel_name'            => 'pm2_5',
                    'database_field_name'   => null,
                    'local_name'            => 'pm2_5',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'o3',
                    'description'           => null,
                    'excel_name'            => 'o3',
                    'database_field_name'   => null,
                    'local_name'            => 'o3_local_ppt',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'so2',
                    'description'           => null,
                    'excel_name'            => 'so2',
                    'database_field_name'   => null,
                    'local_name'            => 'so2_local_ppt',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'co',
                    'description'           => null,
                    'excel_name'            => 'co',
                    'database_field_name'   => null,
                    'local_name'            => 'co_local_ppt',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Temperatura máxima',
                    'description'           => null,
                    'excel_name'            => 'temperatura_max',
                    'database_field_name'   => null,
                    'local_name'            => 'max_temperature',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Temperatura mínima',
                    'description'           => null,
                    'excel_name'            => 'temperatura_min',
                    'database_field_name'   => null,
                    'local_name'            => 'min_temperature',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Temperatura media',
                    'description'           => null,
                    'excel_name'            => 'temperatura_med',
                    'database_field_name'   => null,
                    'local_name'            => 'avg_temperature',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Brillo',
                    'description'           => null,
                    'excel_name'            => 'brillo',
                    'database_field_name'   => null,
                    'local_name'            => 'brightness',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'pst',
                    'description'           => null,
                    'excel_name'            => 'pst',
                    'database_field_name'   => null,
                    'local_name'            => 'pst',
                    'decimal_precision'     => 2,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'hydrostatic_charge',
                    'description'           => null,
                    'excel_name'            => 'hydrostatic_charge',
                    'database_field_name'   => null,
                    'local_name'            => 'hydrostatic_charge',
                    'decimal_precision'     => 4,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'raw_water_temperature',
                    'description'           => null,
                    'excel_name'            => 'raw_water_temperature',
                    'database_field_name'   => null,
                    'local_name'            => 'raw_water_temperature',
                    'decimal_precision'     => 4,
                    'unit'                  => null,
                    'correct_serialization' => 'average',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
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
        DB::connection('administrator')->table('variable')->delete();
    }
}
