<?php

use Illuminate\Database\Seeder;

class AlertFloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('alert_flood')->insert(
            [
                [
                    # id            => 1
                    'basin_id'      => 1,
                    'name'          => 'Alerta Inuncación Antenas Alto del Guamo',
                    'code'          => 'alert_flood_antenas_guamo',
                    'active'        => true,
                    'limit_red'     => 9.4,
                    'icon'          => 'flood_icon'
                ],
                [
                    # id            => 2
                    'basin_id'      => 1,
                    'name'          => 'Alerta Inuncación CDI San Sebastian',
                    'code'          => 'alert_flood_sebatian_guamo',
                    'active'        => true,
                    'limit_red'     => 9.4,
                    'icon'          => 'flood_icon'
                ],
                [
                    # id            => 3
                    'basin_id'      => 2,
                    'name'          => 'Alerta Inuncación Alto de la Coca',
                    'code'          => 'alert_flood_coca_olivares',
                    'active'        => true,
                    'limit_red'     => 11.6,
                    'icon'          => 'flood_icon'
                ],
                [
                    # id            => 4
                    'basin_id'      => 2,
                    'name'          => 'Alerta Inuncación Mirador',
                    'code'          => 'alert_flood_mirador_olivares',
                    'active'        => true,
                    'limit_red'     => 11.6,
                    'icon'          => 'flood_icon'
                ],
                [
                    # id            => 5
                    'basin_id'      => 3,
                    'name'          => 'Alerta Inuncación Hacienda Manzanares',
                    'code'          => 'alert_flood_manzanares_manizales',
                    'active'        => true,
                    'limit_red'     => 11.2,
                    'icon'          => 'flood_icon'
                ],
                [
                    # id            => 6
                    'basin_id'      => 3,
                    'name'          => 'Alerta Inuncación Finca la Paz',
                    'code'          => 'alert_flood_paz_finca',
                    'active'        => true,
                    'limit_red'     => 11.2,
                    'icon'          => 'flood_icon'
                ],
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
        DB::connection('administrator')->table('alert_flood')->delete();
    }
}
