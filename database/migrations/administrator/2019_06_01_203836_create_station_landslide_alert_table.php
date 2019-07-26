<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationLandslideAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('station_landslide_alert', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('landslide_alert_id');

            $table->boolean('primary')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('visible')->default(true);
            $table->float('distance')->nullable();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('landslide_alert_id')->references('id')->on('alert_landslide')->onDelete('cascade');

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
        Schema::connection('administrator')->dropIfExists('station_landslide_alert');
    }
}
