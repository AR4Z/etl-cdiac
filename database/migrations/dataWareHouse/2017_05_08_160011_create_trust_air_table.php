<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrustAirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('trust_air', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('estacion_sk');
            $table->integer('fecha_sk');

            $table->integer('total_incoming_so2')->nullable();
            $table->integer('total_good_so2')->nullable();
            $table->double('support_so2')->nullable();
            $table->double('trust_so2')->nullable();

            $table->integer('total_incoming_co')->nullable();
            $table->integer('total_good_co')->nullable();
            $table->double('support_co')->nullable();
            $table->double('trust_co')->nullable();

            $table->integer('total_incoming_o3')->nullable();
            $table->integer('total_good_o3')->nullable();
            $table->double('support_o3')->nullable();
            $table->double('trust_o3')->nullable();

            $table->integer('total_incoming_pm10')->nullable();
            $table->integer('total_good_pm10')->nullable();
            $table->double('support_pm10')->nullable();
            $table->double('trust_pm10')->nullable();

            $table->integer('total_incoming_pm2_5')->nullable();
            $table->integer('total_good_pm2_5')->nullable();
            $table->double('support_pm2_5')->nullable();
            $table->double('trust_pm2_5')->nullable();

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
        Schema::connection('data_warehouse')->dropIfExists('trust_air');
    }
}
