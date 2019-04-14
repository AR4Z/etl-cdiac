<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPrecipitationFact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('event_rainfall_fact', function (Blueprint $table)
        {
            $table->unsignedBigInteger('station_sk');
            $table->unsignedBigInteger('date_sk');
            $table->unsignedBigInteger('time_sk');

            $table->dateTime('date_time')->nullable();

            $table->integer('duration')->nullable();
            $table->double('magnitude',5,2)->nullable();
            $table->double('intensity',5,2)->nullable();
            $table->double('primary_betas',5,2)->nullable();
            $table->double('index_n',5,2)->nullable();

            $table->string('classification_lkp')->nullable();
            $table->string('classification_aemet')->nullable();
            $table->string('classification_moncho')->nullable();
            $table->string('classification_idea')->nullable();

            $table->longText('comment')->nullable();

            $table->primary(['station_sk', 'date_sk', 'time_sk'], 'event_rainfall_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('event_rainfall_fact');
    }
}
