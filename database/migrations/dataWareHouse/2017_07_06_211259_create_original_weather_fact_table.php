<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginalWeatherFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('original_weather_fact', function (Blueprint $table) 
        {
            $table->bigInteger('station_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();
            $table->bigInteger('time_sk')->unsigned();

            $table->dateTime('date_time')->nullable();

            $table->string('rainfall')->nullable();
            $table->string('accumulated_rainfall')->nullable();
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
            $table->string('accumulated_evapotranspiration')->nullable();
            $table->string('solar_radiation')->nullable();

            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'original_weather_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('original_weather_fact');
    }
}
