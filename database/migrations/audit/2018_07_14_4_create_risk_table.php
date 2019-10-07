<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audit')->create('risk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('risk_type');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();
            $table->integer('station_id')->nullable();
            $table->integer('var_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->float('minimum_range');
            $table->float('maximum_range');
            $table->string('negative_rule');
            $table->string('null_rule');
            $table->integer('difference_rule');
            $table->string('other_rule',500)->nullable();


            $table->timestamps();

            $table->foreign('risk_type')->references('id')->on('risk_type')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('audit')->dropIfExists('risk');
    }
}
