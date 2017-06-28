<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EquipCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('equipment_category')->insert(
            [
                [
                    'name'          => 'Sensores',
                    'description'   => 'Sensores',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Equipos comunicación',
                    'description'   => 'Equipos comunicación',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Equipos de respaldo+protección',
                    'description'   => 'Equipos de respaldo+protección',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
                [
                    'name'          => 'Emplazamiento+seguridad',
                    'description'   => 'Emplazamiento+seguridad',
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
        DB::connection('administrator')->table('equipment_category')->delete();
    }
}
