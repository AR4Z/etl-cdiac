<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariableStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('variable_station', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_id');
            $table->unsignedInteger('variable_id');
            $table->double('maximum')->nullable();
            $table->double('minimum')->nullable();
            $table->double('previous_deference')->nullable();
            $table->string('correction_type')->nullable();
            $table->boolean('rt_active')->default(false);
            $table->boolean('etl_active')->default(true);
            $table->boolean('comment',500)->nullable();

            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('variable_id')->references('id')->on('variable')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('variable_station');
    }
}
