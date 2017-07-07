<?php

use Illuminate\Database\Seeder;
use App\Entities\DataWareHouse\SourceDim;

class SourceDimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SourceDim::insert([
            ['source_type' => 'fija', 'name' => 'Bebidas y alimentos'],
            ['source_type' => 'fija', 'name' => 'Fundición'],
            ['source_type' => 'fija', 'name' => 'Incineración de residuos'],
            ['source_type' => 'fija', 'name' => 'Industria química'],
            ['source_type' => 'fija', 'name' => 'Madera'],
            ['source_type' => 'fija', 'name' => 'Metalúrgica'],
            ['source_type' => 'fija', 'name' => 'Minerales'],
            ['source_type' => 'fija', 'name' => 'Otros'],
            ['source_type' => 'fija', 'name' => 'Tejas'],

            ['source_type' => 'móvil', 'name' => 'Vehículo de pasajeros (PC)'],
            ['source_type' => 'móvil', 'name' => 'Motos (2w)'],
            ['source_type' => 'móvil', 'name' => 'Taxi'],
            ['source_type' => 'móvil', 'name' => 'Bus'],
            ['source_type' => 'móvil', 'name' => 'Pesados (Truck)'],

        ]);
    }
}
