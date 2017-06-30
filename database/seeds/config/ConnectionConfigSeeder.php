<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConnectionConfigSeeder extends Seeder
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
          'database'  => 'caldas_db',
          'username'  => 'usrConsulta',
          'password'  => encrypt('consulta'),
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
          'database'  => 'chec_db',
          'username'  => 'usrConsulta',
          'password'  => encrypt('consulta'),
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
          'database'  => 'udeger_db',
          'username'  => 'usrConsulta',
          'password'  => encrypt('consulta'),
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
          'database'  => 'manizales_db',
          'username'  => 'usrConsulta',
          'password'  => encrypt('consulta'),
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
          'database'  => 'nevados_db',
          'username'  => 'usrConsulta',
          'password'  => encrypt('consulta'),
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
