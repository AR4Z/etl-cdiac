<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityEquipmentMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_equipment_maintenance', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('equipment_maintenance_id');
            $table->unsignedInteger('activity_id');

            $table->timestamps();

            $table->foreign('equipment_maintenance_id')->references('id')->on('equipment_maintenance')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_equipment_maintenance');
    }
}
