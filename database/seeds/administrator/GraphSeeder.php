<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('graph')->insert(
            [
                [
                    'name'              => 'Precipitación últimos 3 Días (A3)',
                    'description'       => 'Gráfica del antecente de lluvia de los últimos 3 días',
                    'graph_file_name'   => 'graficaPrecipitacionA3.php',
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ],
                [
                    'name'              => 'Precipitación últimos 25 Días (A25)',
                    'description'       => 'A25',
                    'graph_file_name'   => 'graficaPrecipitacionA25.php',
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ],
                [
                    'name'              => 'Precipitación mes actual',
                    'description'       => 'Mensual',
                    'graph_file_name'   => 'graficaPrecipitacionMensual.php',
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
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
        DB::connection('administrator')->table('graph')->delete();
    }
}
