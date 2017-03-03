<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConnectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redcorpo',
          'net'       => 'Caldas',
          'driver'    => 'mysql',
          'host'      => '172.23.177.60',
          'port'      => '3306',
          'database'  => 'redcaldas',
          'username'  => 'redcorpo',
          'password'  => encrypt('consultacorpocaldas'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redchec',
          'net'       => 'Chec',
          'driver'    => 'mysql',
          'host'      => '172.23.177.60',
          'port'      => '3306',
          'database'  => 'Redchec',
          'username'  => 'chec',
          'password'  => encrypt('central5'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redudeger',
          'net'       => 'UDEGEr',
          'driver'    => 'mysql',
          'host'      => '172.23.177.60',
          'port'      => '3306',
          'database'  => 'BDGOBERNACION',
          'username'  => 'redudeger',
          'password'  => encrypt('gobernacion'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redmanweb',
          'net'       => 'Manizales',
          'driver'    => 'mysql',
          'host'      => '172.23.177.60',
          'port'      => '3306',
          'database'  => 'redmanizales',
          'username'  => 'redmanweb',
          'password'  => encrypt('consultamanizales'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redcorpo',
          'net'       => 'Nevados',
          'driver'    => 'mysql',
          'host'      => '172.23.177.60',
          'port'      => '3306',
          'database'  => 'rednevado',
          'username'  => 'redcorpo',
          'password'  => encrypt('consultacorpocaldas'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );

      DB::connection('config')->table('external_connection')->insert(
        [
          'name'      => 'redcenicafe',
          'active'    => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]
      );
    }
}
