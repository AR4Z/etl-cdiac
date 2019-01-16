<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('map', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();
            $table->integer('initial_zoom')->default(0);
            $table->double('initial_latitude_degrees')->nullable();
            $table->double('initial_latitude_minutes')->nullable();
            $table->double('initial_latitude_seconds')->nullable();
            $table->string('center_latitude_direction')->nullable();
            $table->double('center_longitude_degrees')->nullable();
            $table->double('center_longitude_minutes')->nullable();
            $table->double('center_longitude_seconds')->nullable();
            $table->string('center_longitude_direction')->nullable();
            $table->boolean('rt_active')->default(false);

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
        Schema::connection('administrator')->dropIfExists('map');
    }
}
