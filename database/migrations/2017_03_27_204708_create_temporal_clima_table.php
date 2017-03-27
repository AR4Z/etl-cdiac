<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporalClimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('temporal_weather', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('estacion_sk')->nullable();
            $table->integer('fecha_sk')->nullable();
            $table->integer('tiempo_sk')->nullable();
            $table->string('fecha')->nullable();
            $table->string('hora')->nullable();
            $table->string('precipitacion')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('brillo')->nullable();
            $table->string('humedad_relativa')->nullable();
            $table->string('nivel')->nullable();
            $table->string('caudal')->nullable();
            $table->string('velocidad_viento')->nullable();
            $table->string('direccion_viento')->nullable();
            $table->string('presion_barometrica')->nullable();
            $table->string('evapotranspiracion')->nullable();
            $table->string('radiacion_solar')->nullable();
            $table->string('observaciones')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('temporal_weather');
    }
}
