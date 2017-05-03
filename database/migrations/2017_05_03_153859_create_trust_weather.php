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

            $table->integer('estacion_sk');
            $table->integer('fecha_sk');

            $table->integer('total_incoming_precipitacion')->default(0);
            $table->integer('total_good_precipitacion')->default(0);
            $table->double('support_precipitacion')->default(0);
            $table->double('trust_precipitacion')->default(0);

            $table->integer('total_incoming_temperatura')->default(0);
            $table->integer('total_good_temperatura')->default(0);
            $table->double('support_temperatura')->default(0);
            $table->double('trust_temperatura')->default(0);

            $table->integer('total_incoming_brillo')->default(0);
            $table->integer('total_good_brillo')->default(0);
            $table->double('support_brillo')->default(0);
            $table->double('trust_brillo')->default(0);

            $table->integer('total_incoming_humedad_relativa')->default(0);
            $table->integer('total_good_humedad_relativa')->default(0);
            $table->double('support_humedad_relativa')->default(0);
            $table->double('trust_humedad_relativa')->default(0);

            $table->integer('total_incoming_nivel')->default(0);
            $table->integer('total_good_nivel')->default(0);
            $table->double('support_nivel')->default(0);
            $table->double('trust_nivel')->default(0);


            $table->integer('total_incoming_caudal')->default(0);
            $table->integer('total_good_caudal')->default(0);
            $table->double('support_caudal')->default(0);
            $table->double('trust_caudal')->default(0);

            $table->integer('total_incoming_velocidad_viento')->default(0);
            $table->integer('total_good_velocidad_viento')->default(0);
            $table->double('support_velocidad_viento')->default(0);
            $table->double('trust_velocidad_viento')->default(0);

            $table->integer('total_incoming_direccion_viento')->default(0);
            $table->integer('total_good_direccion_viento')->default(0);
            $table->double('support_direccion_viento')->default(0);
            $table->double('trust_direccion_viento')->default(0);

            $table->integer('total_incoming_presion_barometrica')->default(0);
            $table->integer('total_good_presion_barometrica')->default(0);
            $table->double('support_presion_barometrica')->default(0);
            $table->double('trust_presion_barometrica')->default(0);

            $table->integer('total_incoming_evapotranspiracion')->default(0);
            $table->integer('total_good_evapotranspiracion')->default(0);
            $table->double('support_evapotranspiracion')->default(0);
            $table->double('trust_evapotranspiracion')->default(0);

            $table->integer('total_incoming_radiacion_solar')->default(0);
            $table->integer('total_good_radiacion_solar')->default(0);
            $table->double('support_radiacion_solar')->default(0);
            $table->double('trust_radiacion_solar')->default(0);

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
