<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationNetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('station_net', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('net_id');
            $table->unsignedInteger('station_id');
            $table->boolean('rt_active')->default(false);

            $table->timestamps();

            $table->foreign('net_id')->references('id')->on('net')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('station_net');
    }
}
