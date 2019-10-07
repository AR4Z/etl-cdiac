<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('role')->insert(
            [

                [
                    # id => 1
                    'code'                      => '1',
                    'name'                      => 'admin',
                    'description'               => 'usuario con acceso a todas las aplicaciones',

                ],
                [
                    # id => 2
                    'code'                      => '2',
                    'name'                      => 'admin_cdiac',
                    'description'               => 'usuario con acceso solo a cdiac',

                ],
                [
                    # id => 3
                    'code'                      => '3',
                    'name'                      => 'guest',
                    'description'               => 'usuario invitado por 24 horas',

                ],
                [
                    # id => 4
                    'code'                      => '4',
                    'name'                      => 'normal_user',
                    'description'               => 'usuario con accesos restringidos',

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
        DB::connection('public')->table('role')->delete();
    }
}
