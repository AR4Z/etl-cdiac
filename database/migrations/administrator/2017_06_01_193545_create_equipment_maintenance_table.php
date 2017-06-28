<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('equipment_maintenance', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('maintenance_id');
            $table->unsignedInteger('equipment_id');

            $table->timestamps();

            $table->foreign('maintenance_id')->references('id')->on('maintenance')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('equipment_maintenance');
    }
}
