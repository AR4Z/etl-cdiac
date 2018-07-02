<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('air_fact', function (Blueprint $table) {

            $table->bigInteger('station_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();
            $table->bigInteger('time_sk')->unsigned();

            $table->decimal('so2_local_ppb', 10, 2)->nullable();
            #$table->decimal('so2_local_ugm3', 10, 2)->nullable();
            $table->decimal('so2_estan_ugm3', 10, 2)->nullable();

            $table->decimal('co_local_ppb', 10, 2)->nullable();
            #$table->decimal('co_local_ugm3', 10, 2)->nullable();
            $table->decimal('co_estan_ugm3', 10, 2)->nullable();

            $table->decimal('o3_local_ppb', 10, 2)->nullable();
            #$table->decimal('o3_local_ugm3', 10, 2)->nullable();
            $table->decimal('o3_estan_ugm3', 10, 2)->nullable();

            $table->decimal('pm10', 10, 2)->nullable();
            $table->decimal('pm2_5', 10, 2)->nullable();
            $table->decimal('pst', 10, 2)->nullable();

            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'air_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('air_fact');
    }
}
