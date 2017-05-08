<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrustWeather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('trust_weather', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('estacion_sk');
            $table->integer('fecha_sk');

            $table->integer('total_incoming_precipitacion')->nullable();
            $table->integer('total_good_precipitacion')->nullable();
            $table->double('support_precipitacion')->nullable();
            $table->double('trust_precipitacion')->nullable();

            $table->integer('total_incoming_temperatura')->nullable();
            $table->integer('total_good_temperatura')->nullable();
            $table->double('support_temperatura')->nullable();
            $table->double('trust_temperatura')->nullable();

            $table->integer('total_incoming_brillo')->nullable();
            $table->integer('total_good_brillo')->nullable();
            $table->double('support_brillo')->nullable();
            $table->double('trust_brillo')->nullable();

            $table->integer('total_incoming_humedad_relativa')->nullable();
            $table->integer('total_good_humedad_relativa')->nullable();
            $table->double('support_humedad_relativa')->nullable();
            $table->double('trust_humedad_relativa')->nullable();

            $table->integer('total_incoming_nivel')->nullable();
            $table->integer('total_good_nivel')->nullable();
            $table->double('support_nivel')->nullable();
            $table->double('trust_nivel')->nullable();


            $table->integer('total_incoming_caudal')->nullable();
            $table->integer('total_good_caudal')->nullable();
            $table->double('support_caudal')->nullable();
            $table->double('trust_caudal')->nullable();

            $table->integer('total_incoming_velocidad_viento')->nullable();
            $table->integer('total_good_velocidad_viento')->nullable();
            $table->double('support_velocidad_viento')->nullable();
            $table->double('trust_velocidad_viento')->nullable();

            $table->integer('total_incoming_direccion_viento')->nullable();
            $table->integer('total_good_direccion_viento')->nullable();
            $table->double('support_direccion_viento')->nullable();
            $table->double('trust_direccion_viento')->nullable();

            $table->integer('total_incoming_presion_barometrica')->nullable();
            $table->integer('total_good_presion_barometrica')->nullable();
            $table->double('support_presion_barometrica')->nullable();
            $table->double('trust_presion_barometrica')->nullable();

            $table->integer('total_incoming_evapotranspiracion')->nullable();
            $table->integer('total_good_evapotranspiracion')->nullable();
            $table->double('support_evapotranspiracion')->nullable();
            $table->double('trust_evapotranspiracion')->nullable();

            $table->integer('total_incoming_radiacion_solar')->nullable();
            $table->integer('total_good_radiacion_solar')->nullable();
            $table->double('support_radiacion_solar')->nullable();
            $table->double('trust_radiacion_solar')->nullable();

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
        Schema::connection('data_warehouse')->dropIfExists('trust_weather');
    }
}
