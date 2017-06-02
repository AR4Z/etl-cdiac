<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_type_id');
            $table->unsignedInteger('owner_net_id');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();
            $table->string('table_db_name')->nullable();
            $table->integer('measurements_per_day')->default(1);
            $table->double('latitude_degrees')->nullable();
            $table->double('latitude_minutes')->nullable();
            $table->double('latitude_seconds')->nullable();
            $table->string('latitude_direction')->nullable();
            $table->double('longitude_degrees')->nullable();
            $table->double('longitude_minutes')->nullable();
            $table->double('longitude_seconds')->nullable();
            $table->string('longitude_direction')->nullable();
            $table->boolean('rt_active')->default(false);
            $table->boolean('etl_active')->default(false);
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('pdf_file')->nullable();

            $table->timestamps();

            $table->foreign('station_type_id')->references('id')->on('station_type')->onDelete('cascade');
            $table->foreign('owner_net_id')->references('id')->on('net')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('station');
    }
}
