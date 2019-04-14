<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherFactTable extends Migration
{
    /**
     * Run the migrations.
     *$table->integer('')->nullable();
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('weather_fact', function (Blueprint $table) {

            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

            $table->dateTime('date_time')->nullable();

            $table->decimal('rainfall', 10, 4)->nullable();
            $table->decimal('temperature', 10, 4)->nullable();
            $table->decimal('max_temperature', 10, 4)->nullable();
            $table->decimal('min_temperature', 10, 4)->nullable();
            $table->decimal('avg_temperature', 10, 4)->nullable();
            $table->decimal('brightness', 10, 4)->nullable();
            $table->decimal('relative_humidity', 10, 4)->nullable();
            $table->decimal('water_level', 10, 4)->nullable();
            $table->decimal('flow_rate', 10, 4)->nullable();
            $table->decimal('wind_speed', 10, 4)->nullable();
            $table->decimal('wind_direction', 10, 4)->nullable();
            $table->decimal('barometric_pressure', 10, 4)->nullable();
            $table->decimal('evapotranspiration', 10, 4)->nullable();
            $table->decimal('solar_radiation', 10, 4)->nullable();
            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'weather_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('weather_fact');
    }
}
