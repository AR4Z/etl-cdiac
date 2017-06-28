<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicalSheetFieldStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('technical_sheet_field_station', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_id');
            $table->unsignedInteger('technical_sheet_field_id');
            $table->boolean('rt_active')->default(false);
            $table->longText('value')->nullable();

            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
            $table->foreign('technical_sheet_field_id')->references('id')->on('technical_sheet_field')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('technical_sheet_field_station');
    }
}
