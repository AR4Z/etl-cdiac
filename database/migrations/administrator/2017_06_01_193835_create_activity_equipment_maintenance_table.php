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
        Schema::connection('administrator')->create('activity_equipment_maintenance', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('equipment_maintenance_id');
            $table->unsignedBigInteger('activity_id');

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
        Schema::connection('administrator')->dropIfExists('activity_equipment_maintenance');
    }
}
