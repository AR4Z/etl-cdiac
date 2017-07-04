<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryCorrectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('temporary_work')->create('temporary_correction', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('temporary_id');
            $table->integer('station_sk');
            $table->integer('date_sk');
            $table->integer('time_sk');
            $table->string('variable');
            $table->string('error_value')->nullable();
            $table->string('observation')->nullable();
            $table->string('correct_value')->nullable();
            $table->string('applied_correction_type')->nullable();

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
        Schema::connection('temporary_work')->dropIfExists('temporary_correction');
    }
}
