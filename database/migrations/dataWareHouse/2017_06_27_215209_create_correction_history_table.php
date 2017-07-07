<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('correction_history', function (Blueprint $table)
        {
            $table->increments('id');
            $table->bigInteger('station_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();
            $table->bigInteger('time_sk')->unsigned();
            $table->string('position')->nullable();
            $table->string('variable')->nullable();
            $table->string('error_value')->nullable();
            $table->string('error_comment')->nullable();
            $table->string('corrected_value')->nullable();
            $table->string('correction_type_applied')->nullable();

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
        Schema::connection('data_warehouse')->dropIfExists('correction_history');
    }
}
