<?php

use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::connection('administrator')->table('owner')->insert(
            [
                [
                   TODO
                ]
            ]
        );
        */
    }
    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('administrator')->table('owner')->delete();
    }
}
