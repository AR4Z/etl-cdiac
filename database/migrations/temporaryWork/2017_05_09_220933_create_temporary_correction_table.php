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

            $table->bigIncrements('id');
            $table->bigInteger('temporary_id');

            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

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
