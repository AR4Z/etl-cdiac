<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('net_id');
            $table->string('name')->unique();
            $table->string('host')->nullable();
            $table->string('port',50)->nullable();
            $table->string('database')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->enum('connection_driver',['pgsql','mysql'])->default('mysql');
            $table->boolean('rt_active')->default(false);
            $table->boolean('etl_active')->default(false);

            $table->timestamps();
            $table->foreign('net_id')->references('id')->on('net')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection');
    }
}
