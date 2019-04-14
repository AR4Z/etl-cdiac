<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('net_map', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('net_id');
            $table->unsignedBigInteger('map_id');
            $table->boolean('rt_active')->default(false);
            $table->boolean('rt_default_active')->default(false);

            $table->timestamps();

            $table->foreign('net_id')->references('id')->on('net')->onDelete('cascade');
            $table->foreign('map_id')->references('id')->on('map')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('net_map');
    }
}
