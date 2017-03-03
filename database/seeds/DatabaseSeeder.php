<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConnectionTableSeeder::class);
        $this->call(StationTableSeeder::class);
        $this->call(OriginStateSeeder::class);
        $this->call(FilterStateSeeder::class);
        $this->call(VariableSeeder::class);
        $this->call(VarForStationTableSeeder::class);
    }
}
