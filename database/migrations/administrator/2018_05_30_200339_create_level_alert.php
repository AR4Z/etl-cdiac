<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelAlert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('administrator')->create('level_alert', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('alert_id');

            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->integer('level')->nullable();
            $table->integer('maximum')->nullable();
            $table->integer('minimum')->nullable();

            $table->timestamps();

            $table->foreign('alert_id')->references('id')->on('alert')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
