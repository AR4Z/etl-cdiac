<?php

use Illuminate\Database\Seeder;

class AdministratorProcessSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypeStationSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(EquipCategorySeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(GraphSeeder::class);
        $this->call(MapSeeder::class);
        $this->call(ConnectionTableSeeder::class);
        $this->call(NetSeeder::class);
        $this->call(TechnicalSheetFieldSeeder::class);
        $this->call(VariableSeeder::class);
        $this->call(StationSeeder::class);
    }

    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {

    }
}