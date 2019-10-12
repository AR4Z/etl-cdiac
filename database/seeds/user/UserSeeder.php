<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('user')->insert(
            [

                [
                    # id => 1
                    'name'                      => 'pruebas',
                    'lastname'                  => 'pruebas',
                    'email'                     => 'lflondonor@gmail.com',
                    'identification_document'   => '1053836141',
                    'password'                  =>  bcrypt('123'),
                    'institution'               => 'unal',
                    'active'                    => TRUE,
                    'confirm'                   => TRUE,
                    'confirmed_code'            => '912044',
                    'encrypt'                   => '1',
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
        DB::connection('public')->table('user')->delete();
    }
}
