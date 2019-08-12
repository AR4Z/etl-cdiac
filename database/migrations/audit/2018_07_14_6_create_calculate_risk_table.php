<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculateRiskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audit')->create('calculate_risk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('risk_id');
            $table->float('impact');
            $table->float('probability');
            $table->float('vulnerability');

            $table->timestamps();

            $table->foreign('risk_id')->references('id')->on('risk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('audit')->dropIfExists('calculate_risk');
    }
}
