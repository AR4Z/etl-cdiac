<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationFloodAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('station_flood_alert', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('flood_alert_id');

            $table->boolean('primary')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('visible')->default(true);
            $table->float('distance')->nullable();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('flood_alert_id')->references('id')->on('alert_flood')->onDelete('cascade');

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
        Schema::connection('administrator')->dropIfExists('station_flood_alert');
    }
}
