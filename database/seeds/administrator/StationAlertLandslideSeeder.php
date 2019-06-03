<?php

use Illuminate\Database\Seeder;

class StationAlertLandslideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('station_landslide_alert')->insert(
            [
                [
                    # id                => 1
                    'station_id'        => 107,
                    'landslide_alert_id'=> 1,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 2
                    'station_id'        => 135,
                    'landslide_alert_id'=> 1,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 3
                    'station_id'        => 6,
                    'landslide_alert_id'=> 1,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 4
                    'station_id'        => 105,
                    'landslide_alert_id'=> 1,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 5
                    'station_id'        => 24,
                    'landslide_alert_id'=> 2,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 6
                    'station_id'        => 120,
                    'landslide_alert_id'=> 2,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 7
                    'station_id'        => 99,
                    'landslide_alert_id'=> 2,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 8
                    'station_id'        => 28,
                    'landslide_alert_id'=> 3,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 9
                    'station_id'        => 17,
                    'landslide_alert_id'=> 3,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 10
                    'station_id'        => 94,
                    'landslide_alert_id'=> 3,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 11
                    'station_id'        => 31,
                    'landslide_alert_id'=> 4,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 12
                    'station_id'        => 7,
                    'landslide_alert_id'=> 4,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 13
                    'station_id'        => 96,
                    'landslide_alert_id'=> 4,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 14
                    'station_id'        => 29,
                    'landslide_alert_id'=> 5,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 15
                    'station_id'        => 19,
                    'landslide_alert_id'=> 6,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 16
                    'station_id'        => 4,
                    'landslide_alert_id'=> 6,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 17
                    'station_id'        => 30,
                    'landslide_alert_id'=> 7,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 18
                    'station_id'        => 89,
                    'landslide_alert_id'=> 7,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 19
                    'station_id'        => 25,
                    'landslide_alert_id'=> 8,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 20
                    'station_id'        => 92,
                    'landslide_alert_id'=> 8,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 21
                    'station_id'        => 93,
                    'landslide_alert_id'=> 8,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 22
                    'station_id'        => 20,
                    'landslide_alert_id'=> 9,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 23
                    'station_id'        => 85,
                    'landslide_alert_id'=> 9,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 24
                    'station_id'        => 104,
                    'landslide_alert_id'=> 9,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 25
                    'station_id'        => 23,
                    'landslide_alert_id'=> 10,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 26
                    'station_id'        => 91,
                    'landslide_alert_id'=> 10,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 27
                    'station_id'        => 98,
                    'landslide_alert_id'=> 10,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 28
                    'station_id'        => 22,
                    'landslide_alert_id'=> 11,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 29
                    'station_id'        => 88,
                    'landslide_alert_id'=> 11,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 30
                    'station_id'        => 26,
                    'landslide_alert_id'=> 12,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 31
                    'station_id'        => 74,
                    'landslide_alert_id'=> 12,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 32
                    'station_id'        => 27,
                    'landslide_alert_id'=> 13,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 33
                    'station_id'        => 86,
                    'landslide_alert_id'=> 13,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 34
                    'station_id'        => 95,
                    'landslide_alert_id'=> 13,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 35
                    'station_id'        => 18,
                    'landslide_alert_id'=> 14,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 36
                    'station_id'        => 84,
                    'landslide_alert_id'=> 14,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 37
                    'station_id'        => 83,
                    'landslide_alert_id'=> 14,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 38
                    'station_id'        => 21,
                    'landslide_alert_id'=> 15,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 39
                    'station_id'        => 69,
                    'landslide_alert_id'=> 15,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
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
        DB::connection('administrator')->table('station_landslide_alert')->delete();
    }
}
