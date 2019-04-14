<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetTable extends Migration
{
    //php artisan migrate --path="database/migrations/administrator"

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('net', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('connection_id');
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
            $table->boolean('etl_active')->default(false);
            $table->integer('map_zoom')->nullable();
            $table->boolean('original_updated')->default(false);
            $table->boolean('filtered_updated')->default(false);

            $table->timestamps();

            $table->foreign('connection_id')->references('id')->on('connection')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('net');
    }
}
