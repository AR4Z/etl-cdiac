<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNeighborhoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('neighborhood', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('zone_id');

            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->foreign('zone_id')->references('id')->on('zone')->onDelete('cascade');

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
        Schema::connection('administrator')->dropIfExists('neighborhood');
    }
}
