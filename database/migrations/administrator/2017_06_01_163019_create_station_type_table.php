<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('station_type', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('code',25);
            $table->string('etl_method')->nullable();
            $table->string('description',500)->nullable();
            $table->string('report_name')->nullable();

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
        Schema::connection('administrator')->dropIfExists('station_type');
    }
}
