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
        Schema::connection('temporary_work')->create('exist_fact_aire', function (Blueprint $table) {

            $table->integer('estacion_sk')->nullable();
            $table->integer('fecha_sk')->nullable();
            $table->integer('tiempo_sk')->nullable();
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
        Schema::connection('temporary_work')->dropIfExists('exist_fact_aire');
    }
}
