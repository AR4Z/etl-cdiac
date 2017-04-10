<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('exist_fact_table', function (Blueprint $table) {

            $table->integer('estacion_sk')->nullable();
            $table->integer('fecha_sk')->nullable();
            $table->integer('tiempo_sk')->nullable();
            $table->string('precipitacion')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('temperatura_max')->nullable();
            $table->string('temperatura_min')->nullable();
            $table->string('temperatura_med')->nullable();
            $table->string('brillo')->nullable();
            $table->string('humedad_relativa')->nullable();
            $table->string('nivel')->nullable();
            $table->string('caudal')->nullable();
            $table->string('velocidad_viento')->nullable();
            $table->string('direccion_viento')->nullable();
            $table->string('presion_barometrica')->nullable();
            $table->string('evapotranspiracion')->nullable();
            $table->string('radiacion_solar')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('exist_fact_table');
    }
}
