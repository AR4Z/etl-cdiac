<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('config')->create('station', function (Blueprint $table) {

          $table->increments('id');
          $table->integer('connection_id');
          $table->string('name');
          $table->string('name_table')->nullable();
          $table->boolean('active')->default(true);
          $table->string('type')->nullable();
          $table->integer('quantity_measurement_day')->nullable();

          $table->foreign('connection_id')->references('id')->on('external_connection')->onDelete('cascade');

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
      Schema::connection('config')->dropIfExists('station');
    }
}
