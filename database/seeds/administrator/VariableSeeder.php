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
                    'excel_name'            => 'Precipitacion(mm)',
                    'database_field_name'   => 'precipitacion_real',
                    'local_name'            => 'rainfall',
                    'decimal_precision'     => 1,
                    'unit'                  => 'mm',
                    'report_name'           => 'reportePrecipitacion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Temperatura del aire',
                    'description'           => 'Es la magnitud física que se caracteriza por el movimiento aleatorio medio de las moléculas en un cuerpo físico.',
                    'excel_name'            => 'Temperatura(ºC)',
                    'database_field_name'   => 'temperatura',
                    'local_name'            => 'temperature',
                    'decimal_precision'     => 1,
                    'unit'                  => '°C',
                    'report_name'           => 'reporteTemperatura.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Humedad Relativa',
                    'description'           => 'Es la relación porcentual entre la cantidad de vapor de agua que tiene el aire y el máximo que podría contener a una temperatura y presión determinada',
                    'excel_name'            => 'Humedad(%)',
                    'database_field_name'   => 'humedad_relativa',
                    'local_name'            => 'relative_humidity',
                    'decimal_precision'     => 0,
                    'unit'                  => '%',
                    'report_name'           => 'reporteHumedad.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Velocidad del Viento',
                    'description'           => 'Es la relación de la distancia recorrida por el aire con respecto del tiempo empleado en recorrerla',
                    'excel_name'            => 'Velocidad(m/s)',
                    'database_field_name'   => 'velocidad',
                    'local_name'            => 'wind_speed',
                    'decimal_precision'     => 1,
                    'unit'                  => 'm/s',
                    'report_name'           => 'reporteVelocidadViento.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Dirección del Viento',
                    'description'           => 'Está definida por el punto del horizonte del observador desde el cual el viento sopla. En la actualidad, se usa internacionalmente la rosa de vientos dividida en 360°',
                    'excel_name'            => 'Direccion(º)',
                    'database_field_name'   => 'direccion',
                    'local_name'            => 'wind_direction',
                    'decimal_precision'     => 0,
                    'unit'                  => '°',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Presión Barométrica',
                    'description'           => 'Es la presión que ejerce la atmósfera que rodea la tierra sobre todos los objetos que se hallan en contacto con ella. Es un elemnto climático cuya existencia se debe a la presencia de la masa atmosférica, varía en forma temporal y espacial',
                    'excel_name'            => 'Presion(mmHg)',
                    'database_field_name'   => 'presion',
                    'local_name'            => 'barometric_pressure',
                    'decimal_precision'     => 1,
                    'unit'                  => 'HPa',
                    'report_name'           => 'reportePresion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Radiación Solar',
                    'description'           => 'Es la energía emitida por el sol, que se propaga en todas las direcciones a través del espacio mediante ondas electromagnéticas. Esta energía es el motor que determina la dinámica de los procesos atmosféricos y el clima',
                    'excel_name'            => 'Radiacion(W/m^2)',
                    'database_field_name'   => 'radiacion',
                    'local_name'            => 'solar_radiation',
                    'decimal_precision'     => 0,
                    'unit'                  => 'W/m2',
                    'report_name'           => 'reporteRadiacion.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Evapotranspiración',
                    'description'           => 'Se define como la pérdida de humedad de una superficie por evaporación directa junto con la pérdida de agua por transpiración de la vegetación',
                    'excel_name'            => 'Evapotranspiracion(mm)',
                    'database_field_name'   => 'evapo_real',
                    'local_name'            => 'evapotranspiration',
                    'decimal_precision'     => 1,
                    'unit'                  => 'mm',
                    'report_name'           => null,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Nivel',
                    'description'           => 'Es la altura desde el fondo de una corriente hasta la lámina de agua',
                    'excel_name'            => 'Nivel (m)',
                    'database_field_name'   => 'nivel',
                    'local_name'            => 'water_level',
                    'decimal_precision'     => 1,
                    'unit'                  => 'cm',
                    'report_name'           => 'reporteNivel.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Caudal',
                    'description'           => 'Es la cantidad de fluido que pasa en una unidad de tiempo. Normalmente se identifica con el flujo volumétrico o volumen que pasa por un área dada en la unidad de tiempo',
                    'excel_name'            => 'Caudal (l/s)',
                    'database_field_name'   => 'caudal',
                    'local_name'            => 'flow_rate',
                    'decimal_precision'     => 4,
                    'unit'                  => 'm3/s',
                    'report_name'           => 'reporteCaudal.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Nivel sobrante',
                    'description'           => 'nivel para estaciones Red Bocatomas CHEC',
                    'excel_name'            => 'Nivel (m)',
                    'database_field_name'   => 'nivel',
                    'local_name'            => 'water_level',
                    'decimal_precision'     => 1,
                    'unit'                  => 'cm',
                    'report_name'           => 'reporteNivel.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Caudal sobrante',
                    'description'           => 'Caudal para las estaciones de la Red Bocatomas CHEC',
                    'excel_name'            => 'Caudal (l/s)',
                    'database_field_name'   => 'caudal',
                    'local_name'            => 'flow_rate',
                    'decimal_precision'     => 4,
                    'unit'                  => 'm3/s',
                    'report_name'           => 'reporteCaudal.php',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'name'                  => 'Estado alarma',
                    'description'           => null,
                    'excel_name'            => 'estado_Alarma',
                    'database_field_name'   => 'estado_Alarma',
                    'local_name'            => null,
                    'decimal_precision'     => 0,
                    'unit'                  => null,
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
