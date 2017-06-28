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
        Schema::connection('administrator')->create('connection', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('host')->nullable();
            $table->string('port',50)->nullable();
            $table->string('database')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->enum('connection_driver',['pgsql','mysql'])->nullable();
            $table->boolean('rt_active')->default(false);
            $table->boolean('etl_active')->default(false);

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
        Schema::connection('administrator')->dropIfExists('connection');
    }
}
