<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VariableStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('variable_station')->insert(
            [
                [
                    'station_id'            => 1,
                    'variable_id'           => 1,
                    'maximum'               => 1,
                    'minimum'               => 1,
                    'previous_deference'    => 1,
                    'correction_type'       => '',
                    'rt_active'             => true,
                    'etl_active'            => true,
                    'comment'               => '',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'station_id'            => 1,
                    'variable_id'           => 1,
                    'maximum'               => 1,
                    'minimum'               => 1,
                    'previous_deference'    => 1,
                    'correction_type'       => '',
                    'rt_active'             => true,
                    'etl_active'            => true,
                    'comment'               => '',
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
        DB::connection('administrator')->table('variable_station')->delete();
    }
}
