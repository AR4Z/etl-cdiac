<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdministratorBaseSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('filter_station')->insert(
            [
                [
                    'station_id'    => 1,
                    'current_date'  => '',
                    'current_time'  => '',
                    'updated'       => false,
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
        DB::connection('administrator')->table('filter_station')->delete();
    }
}