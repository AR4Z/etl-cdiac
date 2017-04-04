<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemporalAirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('temporary_air', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('estacion_sk')->nullable();
            $table->integer('fecha_sk')->nullable();
            $table->integer('tiempo_sk')->nullable();
            $table->string('fecha')->nullable();
            $table->string('hora')->nullable();
            $table->string('so2')->nullable();
            $table->string('o3')->nullable();
            $table->string('co')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('temporal_air');
    }
}
