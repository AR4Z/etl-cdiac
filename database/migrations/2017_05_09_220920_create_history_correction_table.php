<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryCorrectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('history_correction', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('temporary_id');
            $table->integer('estacion_sk');
            $table->integer('fecha_sk');
            $table->integer('tiempo_sk');
            $table->string('variable');
            $table->string('error_value')->nullable();
            $table->string('observation')->nullable();
            $table->string('correct_value')->nullable();
            $table->string('applied_correction_type')->nullable();

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
        Schema::connection('data_warehouse')->dropIfExists('history_correction');
    }
}
