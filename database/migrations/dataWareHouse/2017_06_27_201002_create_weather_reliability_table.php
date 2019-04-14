<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherReliabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('weather_reliability', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');

            $table->bigInteger('rainfall_total_records')->nullable();
            $table->bigInteger('rainfall_correct_records')->nullable();
            $table->decimal('rainfall_support', 10, 4)->nullable();
            $table->decimal('rainfall_trust', 10, 4)->nullable();

            $table->bigInteger('temperature_total_records')->nullable();
            $table->bigInteger('temperature_correct_records')->nullable();
            $table->decimal('temperature_support', 10, 4)->nullable();
            $table->decimal('temperature_trust', 10, 4)->nullable();

            $table->bigInteger('brightness_total_records')->nullable();
            $table->bigInteger('brightness_correct_records')->nullable();
            $table->decimal('brightness_support', 10, 4)->nullable();
            $table->decimal('brightness_trust', 10, 4)->nullable();

            $table->bigInteger('relative_humidity_total_records')->nullable();
            $table->bigInteger('relative_humidity_correct_records')->nullable();
            $table->decimal('relative_humidity_support', 10, 4)->nullable();
            $table->decimal('relative_humidity_trust', 10, 4)->nullable();

            $table->bigInteger('water_level_total_records')->nullable();
            $table->bigInteger('water_level_correct_records')->nullable();
            $table->decimal('water_level_support', 10, 4)->nullable();
            $table->decimal('water_level_trust', 10, 4)->nullable();

            $table->bigInteger('flow_rate_total_records')->nullable();
            $table->bigInteger('flow_rate_correct_records')->nullable();
            $table->decimal('flow_rate_support', 10, 4)->nullable();
            $table->decimal('flow_rate_trust', 10, 4)->nullable();

            $table->bigInteger('wind_speed_total_records')->nullable();
            $table->bigInteger('wind_speed_correct_records')->nullable();
            $table->decimal('wind_speed_support', 10, 4)->nullable();
            $table->decimal('wind_speed_trust', 10, 4)->nullable();

            $table->bigInteger('wind_direction_total_records')->nullable();
            $table->bigInteger('wind_direction_correct_records')->nullable();
            $table->decimal('wind_direction_support', 10, 4)->nullable();
            $table->decimal('wind_direction_trust', 10, 4)->nullable();

            $table->bigInteger('barometric_pressure_total_records')->nullable();
            $table->bigInteger('barometric_pressure_correct_records')->nullable();
            $table->decimal('barometric_pressure_support', 10, 4)->nullable();
            $table->decimal('barometric_pressure_trust', 10, 4)->nullable();

            $table->bigInteger('evapotranspiration_total_records')->nullable();
            $table->bigInteger('evapotranspiration_correct_records')->nullable();
            $table->decimal('evapotranspiration_support', 10, 4)->nullable();
            $table->decimal('evapotranspiration_trust', 10, 4)->nullable();

            $table->bigInteger('solar_radiation_total_records')->nullable();
            $table->bigInteger('solar_radiation_correct_records')->nullable();
            $table->decimal('solar_radiation_support', 10, 4)->nullable();
            $table->decimal('solar_radiation_trust', 10, 4)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('weather_reliability');
    }
}
