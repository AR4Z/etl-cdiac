<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GraphStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('graph_station')->insert(
            [
                [
                    'station_id'    => 1,
                    'graph_id'      => 1,
                    'rt_active'     => true,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'station_id'    => 1,
                    'graph_id'      => 1,
                    'rt_active'     => true,
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
        DB::connection('administrator')->table('graph_station')->delete();
    }
}
