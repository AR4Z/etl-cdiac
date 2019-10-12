<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    //php artisan db:seed --class=DataWareHouseProcessSeeder
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleApplicationSeeder::class);
    }
}
