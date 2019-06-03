<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertLandslideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('alert_landslide', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('zone_id');

            $table->string('name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->boolean('active')->default(true);
            $table->float('limit_yellow')->nullable();
            $table->float('limit_orange')->nullable();
            $table->float('limit_red')->nullable();
            $table->string('icon')->nullable();

            $table->foreign('zone_id')->references('id')->on('zone')->onDelete('cascade');


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
        Schema::connection('administrator')->dropIfExists('alert_landslide');
    }
}
