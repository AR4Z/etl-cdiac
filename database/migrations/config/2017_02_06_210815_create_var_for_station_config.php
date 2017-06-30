<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVarForStationConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('config')->create('var_for_station', function (Blueprint $table) {

          $table->increments('id');
          $table->integer('station_id');
          $table->integer('variable_id');
          $table->float('minimum', 8, 4)->nullable();
          $table->float('maximum', 8, 4)->nullable();
          $table->float('previous_difference', 8, 4)->nullable();
          $table->string('correction_type')->nullable();

          $table->timestamps();

          $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
          $table->foreign('variable_id')->references('id')->on('variable')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('config')->dropIfExists('var_for_station');
    }
}
