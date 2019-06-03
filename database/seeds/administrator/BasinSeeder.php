<?php

use Illuminate\Database\Seeder;

class BasinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('basin')->insert(
            [
                [
                    'name'          => 'Q. El Guamo',
                    'code'          => 'q_guamo',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Q. Olivares',
                    'code'          => 'q_olivares',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Q. Manizales',
                    'code'          => 'q_manizales',
                    'description'   => '',
                    'kml'           => null
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
        DB::connection('administrator')->table('basin')->delete();
    }
}
