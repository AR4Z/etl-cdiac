<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('equipment')->insert(
            [
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Termohigrómetro',
                    'description'           => 'Termohigrómetro',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Anemómetro y veleta',
                    'description'           => 'Anemómetro y veleta',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Pluviómetro',
                    'description'           => 'Pluviómetro',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Radiómetro',
                    'description'           => 'Radiómetro',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Barómetro',
                    'description'           => 'Barómetro',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Sensor nivel',
                    'description'           => 'Sensor nivel',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Panel solar ISS',
                    'description'           => 'Panel solar ISS',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Batería ISS',
                    'description'           => 'Batería ISS',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 1,
                    'name'                  => 'Consola+datalogger',
                    'description'           => 'Consola+datalogger',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'UCR',
                    'description'           => 'UCR',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'UIP',
                    'description'           => 'UIP',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'UAR',
                    'description'           => 'UAR',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Radio base+micrófono',
                    'description'           => 'Radio base+micrófono',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Antena',
                    'description'           => 'Antena',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Cable antena',
                    'description'           => 'Cable antena',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Amplificador',
                    'description'           => 'Amplificador',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Bocinas',
                    'description'           => 'Bocinas',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Sirena',
                    'description'           => 'Sirena',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 2,
                    'name'                  => 'Selector',
                    'description'           => 'Selector',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Batería',
                    'description'           => 'Batería',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Fuente cargadora',
                    'description'           => 'Fuente cargadora',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Regulador',
                    'description'           => 'Regulador',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Regulador isolado',
                    'description'           => 'Regulador isolado',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'DPS',
                    'description'           => 'DPS',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Protector de antena',
                    'description'           => 'Protector de antena',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Panel solar',
                    'description'           => 'Panel solar',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Regulador panel',
                    'description'           => 'Regulador panel',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Breaker',
                    'description'           => 'Breaker',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Pararrayos',
                    'description'           => 'Pararrayos',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 3,
                    'name'                  => 'Puesta a tierra',
                    'description'           => 'Puesta a tierra',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 4,
                    'name'                  => 'Soporte sensores',
                    'description'           => 'Soporte sensores',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 4,
                    'name'                  => 'Soporte paneles',
                    'description'           => 'Soporte paneles',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 4,
                    'name'                  => 'Soporte gabinete',
                    'description'           => 'Soporte gabinete',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 4,
                    'name'                  => 'Cerramiento',
                    'description'           => 'Cerramiento',
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ],
                [
                    'equipment_category_id' => 4,
                    'name'                  => 'Gabinete',
                    'description'           => 'Gabinete',
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
        DB::connection('administrator')->table('equipment')->delete();
    }
}
