<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('public')->table('user_permission')->insert(
            [

                [
                    # id => 1
                    'user_id'                      => '1',
                    'permission_id'                => '1',
                    'active_time'                  => '0',
                    'active'                       => TRUE,

                ],
                [
                    # id => 1
                    'user_id'                      => '1',
                    'permission_id'                => '2',
                    'active_time'                  => '0',
                    'active'                       => TRUE,

                ],
                [
                    # id => 1
                    'user_id'                      => '1',
                    'permission_id'                => '3',
                    'active_time'                  => '24',
                    'active'                       => TRUE,

                ],
                [
                    # id => 1
                    'user_id'                      => '1',
                    'permission_id'                => '4',
                    'active_time'                  => '0',
                    'active'                       => TRUE,

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
        DB::connection('public')->table('user_permission')->delete();
    }
}
