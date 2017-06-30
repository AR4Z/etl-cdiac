<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterStateConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('config')->create('filter_state', function (Blueprint $table) {

          $table->increments('id');
          $table->integer('station_id');
          $table->string('current_date')->default('1000-01-01');
          $table->string('current_time')->default('00:00:00');
          $table->boolean('it_update')->default(false);

          $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');

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
      Schema::connection('config')->dropIfExists('filter_state');
    }
}
