<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('exist_fact_weather', function (Blueprint $table) {

            $table->integer('station_sk')->nullable();
            $table->integer('date_sk')->nullable();
            $table->integer('time_sk')->nullable();
            $table->string('rainfall')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('temperature')->nullable();
            $table->string('max_temperature')->nullable();
            $table->string('min_temperature')->nullable();
            $table->string('avg_temperature')->nullable();
            $table->string('brightness')->nullable();
            $table->string('relative_humidity')->nullable();
            $table->string('water_level')->nullable();
            $table->string('flow_rate')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_direction')->nullable();
            $table->string('barometric_pressure')->nullable();
            $table->string('evapotranspiration')->nullable();
            $table->string('solar_radiation')->nullable();
            $table->string('comment')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('temporary_work')->dropIfExists('exist_fact_weather');
    }
}
