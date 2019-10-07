<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audit')->create('audit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('station_id');
            $table->integer('risk_id');
            $table->integer('calculate_risk_id');
            $table->integer('analysis_id');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('risk_id')->references('id')->on('risk')->onDelete('cascade');
            $table->foreign('calculate_risk_id')->references('id')->on('calculate_risk')->onDelete('cascade');
            $table->foreign('analysis_id')->references('id')->on('analysis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('audit')->dropIfExists('audit');
    }
}
