<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('filter_state', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('station_id');
            $table->string('current_date')->default('1800-01-01');
            $table->string('current_time')->default('0:00:00');
            $table->boolean('updated')->default(false);

            $table->timestamps();
            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('filter_state');
    }
}
