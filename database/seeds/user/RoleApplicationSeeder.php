<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::connection('public')->table('role_application')->insert(
            [

                [
                    # id => 1
                    'role_id'                      => '1',
                    'application_id'               => '1',

                ],
                [
                    # id => 2
                    'role_id'                      => '1',
                    'application_id'               => '2',

                ],
                [
                    # id => 3
                    'role_id'                      => '1',
                    'application_id'               => '3',

                ],
                [
                    # id => 4
                    'role_id'                      => '1',
                    'application_id'               => '4',

                ]
            ]
        );*/
    }
    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('public')->table('role_application')->delete();
    }
}
