<?php

use Illuminate\Database\Seeder;
use App\Entities\DataWareHouse\InventoryFact;

class InventoryFactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryFact::insert([
            ['source_sk' => 1, 'date_sk' => 27030, 'co' => 46.0, 'nox' => 39.9, 'sox' => 62.9, 'pm10' => 23.5, 'tsp' => 45.5, 'voc' => 0.71, 'metals' => 0.10, 'co2' => 26740, 'ch4' => 0.6, 'n2o' => 0.4, 'quantity' => null,'comment' => null,],
            ['source_sk' => 2, 'date_sk' => 27030, 'co' => 160.1, 'nox' => 14.9, 'sox' => 9.5, 'pm10' => 8.6, 'tsp' => 39.2, 'voc' => 2.08, 'metals' => 0.11, 'co2' => 18609, 'ch4' => 0.5, 'n2o' => 0.5, 'quantity' => null,'comment' => null,],
            ['source_sk' => 3, 'date_sk' => 27030, 'co' => 0.2, 'nox' => 4.7, 'sox' => 0.4, 'pm10' => 0.2, 'tsp' => 0.3, 'voc' => 0.02, 'metals' => 0.01, 'co2' => 468, 'ch4' => 0.0, 'n2o' => 0.0, 'quantity' => null,'comment' => null,],
            ['source_sk' => 4, 'date_sk' => 27030, 'co' => 0.4, 'nox' => 3.0, 'sox' => 16.0, 'pm10' => 0.1, 'tsp' => 0.1, 'voc' => 0.02, 'metals' => 0.0, 'co2' => 1369, 'ch4' => 0.0, 'n2o' => 0.0, 'quantity' => null,'comment' => null,],
            ['source_sk' => 5, 'date_sk' => 27030, 'co' => 0.7, 'nox' => 2.9, 'sox' => 12.7, 'pm10' => 0.8, 'tsp' => 3.4, 'voc' => 0.04, 'metals' => 0.01, 'co2' => 1912, 'ch4' => 0.1, 'n2o' => 0.0, 'quantity' => null,'comment' => null,],
            ['source_sk' => 6, 'date_sk' => 27030, 'co' => 1.8, 'nox' => 8.7, 'sox' => 0.1, 'pm10' => 0.2, 'tsp' => 4.2, 'voc' => 0.12, 'metals' => 0.0, 'co2' => 2687, 'ch4' => 0.0, 'n2o' => 0.0, 'quantity' => null,'comment' => null,],
            ['source_sk' => 7, 'date_sk' => 27030, 'co' => 7.4, 'nox' => 6.5, 'sox' => 11.6, 'pm10' => 3.4, 'tsp' => 26.5, 'voc' => 1.26, 'metals' => 0.02, 'co2' => 4101, 'ch4' => 0.6, 'n2o' => 0.1, 'quantity' => null,'comment' => null,],
            ['source_sk' => 8, 'date_sk' => 27030, 'co' => 0.0, 'nox' => 1.7, 'sox' => 0.0, 'pm10' => 0.1, 'tsp' => 0.2, 'voc' => 0.0, 'metals' => 0.0, 'co2' => 64, 'ch4' => 0.0, 'n2o' => 0.0, 'quantity' => null,'comment' => null,],
            ['source_sk' => 9, 'date_sk' => 27030, 'co' => 2.5, 'nox' => 7.2, 'sox' => 0.3, 'pm10' => 0.4, 'tsp' => 0.7, 'voc' => 0.12, 'metals' => 0.0, 'co2' => 8127, 'ch4' => 0.0, 'n2o' => 0.1, 'quantity' => null,'comment' => null,],
            ['source_sk' => 10, 'date_sk' => 27030, 'co' => 15902, 'nox' => 1023, 'sox' => 18, 'pm10' => 21, 'tsp' => null, 'voc' => 1340, 'metals' => null, 'co2' => 191902, 'ch4' => 881, 'n2o' => 6.6, 'quantity' => 64090,'comment' => null,],
            ['source_sk' => 11, 'date_sk' => 27030, 'co' => 21542, 'nox' => 141, 'sox' => 5.1, 'pm10' => 184, 'tsp' => null, 'voc' => 7841, 'metals' => null, 'co2' => 44208, 'ch4' => 1444, 'n2o' => 0.1, 'quantity' => 60625,'comment' => null,],
            ['source_sk' => 12, 'date_sk' => 27030, 'co' => 4470, 'nox' => 249, 'sox' => 1.2, 'pm10' => 6, 'tsp' => null, 'voc' => 144, 'metals' => null, 'co2' => 48617, 'ch4' => 535, 'n2o' => 2.6, 'quantity' => 2402,'comment' => null,],
            ['source_sk' => 13, 'date_sk' => 27030, 'co' => 755, 'nox' => 2371, 'sox' => 1.2, 'pm10' => 362, 'tsp' => null, 'voc' => 177, 'metals' => null, 'co2' => 118930, 'ch4' => 0, 'n2o' => 0.9, 'quantity' => 2367,'comment' => null,],
            ['source_sk' => 14, 'date_sk' => 27030, 'co' => 727, 'nox' => 1107, 'sox' => 0.5, 'pm10' => 192, 'tsp' => null, 'voc' => 144, 'metals' => null, 'co2' => 50783, 'ch4' => 0, 'n2o' => 0.4, 'quantity' => 2528,'comment' => null,],
        ]);
    }
}
