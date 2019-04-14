<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistFactAire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('exist_fact_air', function (Blueprint $table) {

            $table->unsignedBigInteger('station_sk')->nullable();
            $table->unsignedBigInteger('date_sk')->nullable();
            $table->unsignedBigInteger('time_sk')->nullable();

            $table->string('date_time')->nullable();

            $table->string('date')->nullable();
            $table->string('time')->nullable();

            $table->string('so2_local_ppb')->nullable();
            #$table->string('so2_local_ugm3')->nullable();
            $table->string('so2_estan_ugm3')->nullable();

            $table->string('co_local_ppb')->nullable();
            #$table->string('co_local_ugm3')->nullable();
            $table->string('co_estan_ugm3')->nullable();

            $table->string('o3_local_ppb')->nullable();
            #$table->string('o3_local_ugm3')->nullable();
            $table->string('o3_estan_ugm3')->nullable();

            $table->string('pm10')->nullable();
            $table->string('pm2_5')->nullable();
            $table->string('pst')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('exist_fact_air');
    }
}
