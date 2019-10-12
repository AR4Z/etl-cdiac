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
                    'name'                      => 'Administrador',
                    'description'               => 'usuario con acceso a todas las aplicaciones',

                ],
                [
                    # id => 3
                    'code'                      => '2',
                    'name'                      => 'Invitado',
                    'description'               => 'usuario invitado por 24 horas',

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
