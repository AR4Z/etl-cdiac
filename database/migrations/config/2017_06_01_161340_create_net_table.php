<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();
            $table->string('administrator_name')->nullable();
            $table->double('center_latitude_degrees')->nullable();
            $table->double('center_latitude_minutes')->nullable();
            $table->double('center_latitude_seconds')->nullable();
            $table->string('center_latitude_direction')->nullable();
            $table->double('center_longitude_degrees')->nullable();
            $table->double('center_longitude_minutes')->nullable();
            $table->double('center_longitude_seconds')->nullable();
            $table->string('center_longitude_direction')->nullable();
            $table->boolean('rt_active')->default(false);
            $table->integer('map_zoom')->nullable();
            $table->boolean('original_updated')->default(false);
            $table->boolean('filtered_updated')->default(false);

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
        Schema::dropIfExists('net');
    }
}
