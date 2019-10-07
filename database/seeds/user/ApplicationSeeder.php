<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('application')->insert(
            [

                [
                    # id => 1
                    'name'                      => 'cdiac',
                    'app_url'                   => 'xxxxxx',
                    'description'               => 'aplicación xxxxx para xxxxx',

                ],
                [
                    # id => 2
                    'name'                      => 'riesgos',
                    'app_url'                   => 'xxxxxx',
                    'description'               => 'aplicación xxxxx para xxxxx',

                ],
                [
                    # id => 3
                    'name'                      => 'indicadores',
                    'app_url'                   => 'xxxxxx',
                    'description'               => 'aplicación xxxxx para xxxxx',
                ],
                [
                    # id => 4
                    'name'                      => 'auditoría',
                    'app_url'                   => 'xxxxxx',
                    'description'               => 'aplicación xxxxx para xxxxx',

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
        DB::connection('public')->table('application')->delete();
    }
}
