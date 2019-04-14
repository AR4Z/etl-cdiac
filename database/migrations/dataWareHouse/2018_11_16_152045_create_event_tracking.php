<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('event_rainfall_tracking', function (Blueprint $table)
        {
            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

            $table->integer('time_tracking')->nullable();
            $table->double('value')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk','time_tracking'], 'event_rainfall_tracking_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('event_rainfall_tracking');
    }
}
