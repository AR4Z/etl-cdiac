<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationDimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('station_dim', function (Blueprint $table)
        {    
            $table->unsignedBigInteger('station_sk')->unique();
            $table->string('code', 255)->nullable();
            $table->string('name', 255);
            $table->string('net_name', 255);
            $table->string('typology', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->bigInteger('altitude')->nullable();
            $table->string('owner')->nullable();
            $table->date('start_operation')->nullable();
            $table->date('finish_operation')->nullable();
            $table->longText('comment')->nullable();
            $table->string('basin')->nullable();
            $table->string('sub_basin')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('community_station')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('station_dim');
    }
}
