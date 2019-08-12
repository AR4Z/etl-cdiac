<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    //php artisan db:seed
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministratorProcessSeeder::class);
        $this->call(DataWareHouseProcessSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
