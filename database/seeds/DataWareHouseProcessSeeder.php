<?php

use Illuminate\Database\Seeder;

class DataWareHouseProcessSeeder extends Seeder
{
    //php artisan db:seed --class=DataWareHouseProcessSeeder
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DateDimTableSeeder::class);
        $this->call(TimeDimTableSeeder::class);
        $this->call(SourceDimTableSeeder::class);
        $this->call(StationDimTableSeeder::class);
        $this->call(InventoryFactTableSeeder::class);

    }
}
