<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_id');
            $table->date('scheduled_date')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->string('state')->nullable();
            $table->string('comment',500)->nullable();
            $table->string('maintenance_type')->nullable();
            $table->date('creation_date')->nullable();

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
        Schema::dropIfExists('maintenance');
    }
}
