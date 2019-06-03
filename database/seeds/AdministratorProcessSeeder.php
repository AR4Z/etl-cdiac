<?php

use Illuminate\Database\Seeder;

class AdministratorProcessSeeder extends seeder
{
    //php artisan db:seed --class=AdministratorProcessSeeder

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
        $this->call(FilterStationSeeder::class);
        $this->call(OriginStateSeeder::class);
        $this->call(VariableStationSeeder::class);
        $this->call(AlertSeeder::class);
        $this->call(LevelAlertSeeder::class);
        $this->call(AlertStationSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(OwnerStationSeeder::class);

        $this->call(NeighborhoodSeeder::class);
        $this->call(ZoneSeeder::class);
        $this->call(BasinSeeder::class);
        $this->call(AlertFloodSeeder::class);
        $this->call(AlertLandslideSeeder::class);
        $this->call(StationAlertFloodSeeder::class);
        $this->call(StationAlertLandslideSeeder::class);
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