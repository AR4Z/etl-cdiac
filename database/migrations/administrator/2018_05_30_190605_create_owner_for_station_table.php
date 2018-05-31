<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerForStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('owner_station', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('station_id');
            $table->unsignedInteger('owner_id');

            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owner')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('owner_station');
    }
}
