<?php

use Illuminate\Database\Seeder;

class StationAlertFloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('station_flood_alert')->insert(
            [
                [
                    # id                => 1
                    'station_id'        => 104,
                    'flood_alert_id'    => 1,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 2
                    'station_id'        => 20,
                    'flood_alert_id'    => 1,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 3
                    'station_id'        => 85,
                    'flood_alert_id'    => 1,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 4
                    'station_id'        => 98,
                    'flood_alert_id'    => 1,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 5
                    'station_id'        => 109,
                    'flood_alert_id'    => 2,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 6
                    'station_id'        => 102,
                    'flood_alert_id'    => 2,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 7
                    'station_id'        => 106,
                    'flood_alert_id'    => 2,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 8
                    'station_id'        => 7,
                    'flood_alert_id'    => 2,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 9
                    'station_id'        => 108,
                    'flood_alert_id'    => 3,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 10
                    'station_id'        => 107,
                    'flood_alert_id'    => 3,
                    'primary'           => false,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 11
                    'station_id'        => 105,
                    'flood_alert_id'    => 3,
                    'primary'           => true,
                    'active'            => true,
                    'visible'           => true,
                    'distance'          => null
                ],
                [
                    # id                => 12
                    'station_id'        => 6,
                    'flood_alert_id'    => 3,
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
        DB::connection('administrator')->table('station_flood_alert')->delete();
    }
}
