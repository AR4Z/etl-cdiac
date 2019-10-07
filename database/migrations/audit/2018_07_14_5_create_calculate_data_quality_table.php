<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculateDataQualityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audit')->create('calculate_data_quality', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('data_quality_id');
            $table->integer('risk1');
            $table->integer('risk2');
            $table->integer('risk3');
            $table->integer('risk4');
            $table->integer('risk5');
            $table->float('vulnerability');

            $table->timestamps();

            $table->foreign('data_quality_id')->references('id')->on('data_quality')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('audit')->dropIfExists('calculate_data_quality');
        Schema::connection('audit')->dropIfExists('calculate_data_quality');
    }
}
