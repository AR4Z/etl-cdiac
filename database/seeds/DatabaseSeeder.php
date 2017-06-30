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
        $this->call(ConnectionConfigSeeder::class);
        $this->call(StationTableSeeder::class);
        $this->call(OriginStateConfigSeeder::class);
        $this->call(FilterStateConfigSeeder::class);
        $this->call(VariableTableSeeder::class);
        $this->call(VarForStationTableSeeder::class);
    }
}
