<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('graph_station', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_id');
            $table->unsignedInteger('graph_id');
            $table->boolean('rt_active')->default(false);


            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('graph_id')->references('id')->on('graph')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('graph_station');
    }
}
