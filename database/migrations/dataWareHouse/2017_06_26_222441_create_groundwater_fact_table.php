<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroundwaterFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('groundwater_fact', function (Blueprint $table) {

            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

            $table->dateTime('date_time')->nullable();

            $table->decimal('raw_air_pressure', 10, 4)->nullable();
            $table->decimal('raw_air_temperature', 10, 4)->nullable();
            $table->decimal('raw_water_pressure', 10, 4)->nullable();
            $table->decimal('raw_water_temperature', 10, 4)->nullable();
            $table->decimal('raw_water_level', 10, 4)->nullable();
            $table->decimal('water_temperature', 10, 4)->nullable();
            $table->decimal('groundwater_level', 10, 4)->nullable();
            $table->decimal('hydrostatic_charge', 10, 4)->nullable();
            $table->decimal('well_quota', 10, 4)->nullable();
            $table->decimal('depth', 10, 4)->nullable();
            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'groundwater_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('groundwater_fact');
    }
}
