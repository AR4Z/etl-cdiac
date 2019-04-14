<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistGroundwaterFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('exist_fact_groundwater', function (Blueprint $table) {

            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

            $table->string('date_time')->nullable();

            $table->string('date')->nullable();
            $table->string('time')->nullable();

            $table->string('raw_air_pressure')->nullable();
            $table->string('raw_air_temperature')->nullable();
            $table->string('raw_water_pressure')->nullable();
            $table->string('raw_water_temperature')->nullable();
            $table->string('raw_water_level')->nullable();
            $table->string('water_temperature')->nullable();
            $table->string('groundwater_level')->nullable();
            $table->string('hydrostatic_charge')->nullable();
            $table->string('well_quota')->nullable();
            $table->string('depth')->nullable();
            $table->longText('comment')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('exist_fact_groundwater');
    }
}
