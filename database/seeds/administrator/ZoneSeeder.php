<?php

use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('zone')->insert(
            [
                [
                    'name'          => 'Zona uno',
                    'code'          => 'z1',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona dos',
                    'code'          => 'z2',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona tres',
                    'code'          => 'z3',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona cuantro',
                    'code'          => 'z4',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona Cinco',
                    'code'          => 'z5',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona seis',
                    'code'          => 'z6',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona seis',
                    'code'          => 'z7',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona ocho',
                    'code'          => 'z8',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona nueve',
                    'code'          => 'z9',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona diez',
                    'code'          => 'z10',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona once',
                    'code'          => 'z11',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona doce',
                    'code'          => 'z12',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona trece',
                    'code'          => 'z13',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona 14',
                    'code'          => 'z14',
                    'description'   => '',
                    'kml'           => null
                ],
                [
                    'name'          => 'Zona diez',
                    'code'          => 'z15',
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
        DB::connection('administrator')->table('zone')->delete();
    }
}