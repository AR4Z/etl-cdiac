<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TechnicalSheetFieldStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('technical_sheet_field_station')->insert(
            [
                [
                    'station_id'                => 1,
                    'technical_sheet_field_id'  => 1,
                    'rt_active'                 => true,
                    'value'                     => '',
                    'created_at'                => Carbon::now(),
                    'updated_at'                => Carbon::now(),
                ],
                [
                    'station_id'                => 1,
                    'technical_sheet_field_id'  => 1,
                    'rt_active'                 => true,
                    'value'                     => '',
                    'created_at'                => Carbon::now(),
                    'updated_at'                => Carbon::now(),
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
        DB::connection('administrator')->table('technical_sheet_field_station')->delete();
    }
}
