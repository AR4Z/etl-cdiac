<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ConnectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('connection')->insert(
            [
                [
                    'name'      => 'no_connection',
                    'host'      => null,
                    'port'      => null,
                    'database'  => null,
                    'username'  => null,
                    'password'  => null,
                    'connection_driver' => null,
                    'rt_active'         => false,
                    'etl_active'        => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'redcorpo',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'caldas_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'redchec',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'chec_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'redmanweb',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'manizales_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'rednevados',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'nevados_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'redudeger',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'udeger_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'redsatmanizales',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'satmanizales_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name'      => 'cucuta',
                    'host'      => '172.23.177.60',
                    'port'      => '3306',
                    'database'  => 'cucuta_db',
                    'username'  => 'usrConsulta',
                    'password'  => encrypt('consulta'),
                    'connection_driver' => 'mysql',
                    'rt_active'         => true,
                    'etl_active'        => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
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
        DB::connection('administrator')->table('connection')->delete();
    }
}
