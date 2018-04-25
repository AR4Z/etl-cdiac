<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginalAirFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('original_air_fact', function (Blueprint $table) {
            $table->bigInteger('station_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();
            $table->bigInteger('time_sk')->unsigned();

            $table->string('so2_local_ppt')->nullable();
            $table->string('so2_local_ugm3')->nullable();
            $table->string('so2_estan_ugm3')->nullable();
            $table->string('co_local_ppt')->nullable();
            $table->string('co_local_ugm3')->nullable();
            $table->string('co_estan_ugm3')->nullable();
            $table->string('o3_local_ppt')->nullable();
            $table->string('o3_local_ugm3')->nullable();
            $table->string('o3_estan_ugm3')->nullable();
            $table->string('pm10')->nullable();
            $table->string('pm2_5')->nullable();
            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'original_air_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('original_air_fact');
    }
}
