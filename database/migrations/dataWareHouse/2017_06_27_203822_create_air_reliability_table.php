<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirReliabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('air_reliability', function (Blueprint $table) {

            $table->bigInteger('station_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();

            $table->bigInteger('so2_total_records')->nullable();
            $table->bigInteger('so2_correct_records')->nullable();
            $table->decimal('so2_support', 10, 4)->nullable();
            $table->decimal('so2_trust', 10, 4)->nullable();

            $table->bigInteger('co_total_records')->nullable();
            $table->bigInteger('co_correct_records')->nullable();
            $table->decimal('co_support', 10, 4)->nullable();
            $table->decimal('co_trust', 10, 4)->nullable();

            $table->bigInteger('o3_total_records')->nullable();
            $table->bigInteger('o3_correct_records')->nullable();
            $table->decimal('o3_support', 10, 4)->nullable();
            $table->decimal('o3_trust', 10, 4)->nullable();

            $table->bigInteger('pm10_total_records')->nullable();
            $table->bigInteger('pm10_correct_records')->nullable();
            $table->decimal('pm10_support', 10, 4)->nullable();
            $table->decimal('pm10_trust', 10, 4)->nullable();

            $table->bigInteger('pm2_5_total_records')->nullable();
            $table->bigInteger('pm2_5_correct_records')->nullable();
            $table->decimal('pm2_5_support', 10, 4)->nullable();
            $table->decimal('pm2_5_trust', 10, 4)->nullable();

            $table->primary(['station_sk', 'date_sk'], 'air_reliability_pk');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('air_reliability');
    }
}
