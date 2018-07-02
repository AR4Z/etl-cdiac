<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertForStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('alert_station', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('station_id');
            $table->unsignedInteger('alert_id');

            $table->decimal('flag_level_one')->nullable();
            $table->decimal('flag_level_two')->nullable();
            $table->decimal('flag_level_three')->nullable();

            $table->boolean('active')->default(false);

            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('alert_id')->references('id')->on('alert')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('alert_station');
    }
}
