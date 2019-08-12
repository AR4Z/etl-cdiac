<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('permissions')->insert(
            [

                [
                    # id => 1
                    'code'                      => '1',
                    'name'                      => 'all',
                    'description'               => 'permisos a todo',
                    'application_id'            => '1',
                    'role_id'                   => '1',

                ],
                [
                    # id => 1
                    'code'                      => '2',
                    'name'                      => 'only_view',
                    'description'               => 'solo visualización',
                    'application_id'            => '1',
                    'role_id'                   => '4',

                ],
                [
                    # id => 1
                    'code'                      => '3',
                    'name'                      => 'normal',
                    'description'               => 'permisos normales',
                    'application_id'            => '2',
                    'role_id'                   => '3',

                ],
                [
                    # id => 1
                    'code'                      => '4',
                    'name'                      => 'all_cdiac',
                    'description'               => 'permisos completos cdiac',
                    'application_id'            => '3',
                    'role_id'                   => '2',

                ],
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
        DB::connection('public')->table('permissions')->delete();
    }
}
