<?php

use Illuminate\Database\Seeder;

class AlertLandslideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('alert_landslide')->insert(
            [
                [
                    # id            => 1
                    'zone_id'       => 1,
                    'name'          => 'Alerta Deslizamiento Q. Manizales SKINCO',
                    'code'          => 'alert_landslide_antenas_z1',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 2
                    'zone_id'       => 2,
                    'name'          => 'Alerta Deslizamiento La Nubia',
                    'code'          => 'alert_landslide_nubia_z2',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 3
                    'zone_id'       => 3,
                    'name'          => 'Alerta Deslizamiento Milán Planta Niza',
                    'code'          => 'alert_landslide_niza_z3',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 4
                    'zone_id'       => 4,
                    'name'          => 'Alerta Deslizamiento Yarumos',
                    'code'          => 'alert_landslide_yarumos_z4',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 5
                    'zone_id'       => 5,
                    'name'          => 'Alerta Deslizamiento Posgrados',
                    'code'          => 'alert_landslide_posgrados_z5',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 6
                    'zone_id'       => 6,
                    'name'          => 'Alerta Deslizamiento Aranjuez',
                    'code'          => 'alert_landslide_aranjuez_z5',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 7
                    'zone_id'       => 7,
                    'name'          => 'Alerta Deslizamiento Q. Palogrande Ruta 30',
                    'code'          => 'alert_landslide_ruta30_z6',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 8
                    'zone_id'       => 8,
                    'name'          => 'Alerta Deslizamiento Hospital de Caldas',
                    'code'          => 'alert_landslide_hospital_caldas_z7',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 9
                    'zone_id'       => 9,
                    'name'          => 'Alerta Deslizamiento Bosques del Norte',
                    'code'          => 'alert_landslide_bosques_z8',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 10
                    'zone_id'       => 10,
                    'name'          => 'Alerta Deslizamiento EMAS',
                    'code'          => 'alert_landslide_emas_z9',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 10
                    'zone_id'       => 10,
                    'name'          => 'Alerta Deslizamiento EMAS',
                    'code'          => 'alert_landslide_emas_z10',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 11
                    'zone_id'       => 11,
                    'name'          => 'Alerta Deslizamiento El Carmen',
                    'code'          => 'alert_landslide_carmen_z11',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 12
                    'zone_id'       => 12,
                    'name'          => 'Alerta Deslizamiento Observatorio Vulcanologíco',
                    'code'          => 'alert_landslide_vulcano_z12',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 13
                    'zone_id'       => 13,
                    'name'          => 'Alerta Deslizamiento La Palma',
                    'code'          => 'alert_landslide_palma_z13',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 14
                    'zone_id'       => 14,
                    'name'          => 'Alerta Deslizamiento Alcazares',
                    'code'          => 'alert_landslide_alcazares_z14',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
                ],
                [
                    # id            => 15
                    'zone_id'       => 15,
                    'name'          => 'Alerta Deslizamiento CHEC Uribe',
                    'code'          => 'alert_landslide_chec_z15',
                    'active'        => true,
                    'limit_yellow'  => 200,
                    'limit_orange'  => 300,
                    'limit_red'     => 400,
                    'icon'          => 'landslide_icon'
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
        DB::connection('administrator')->table('alert_landslide')->delete();
    }
}
