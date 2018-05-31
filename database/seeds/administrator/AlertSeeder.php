<?php

use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('alert')->insert(
            [
                [
                    # id => 1
                    'name'          => 'Alerta por deslizamientos',
                    'code'          => 'alert-a25',
                    'description'   => 'El Alerta por deslizamientos se calcula en base al indicador a25',
                    'active'        => true,
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
        DB::connection('administrator')->table('alert')->delete();
    }
}
