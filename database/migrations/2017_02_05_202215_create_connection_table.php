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
      Schema::connection('config')->create('external_connection', function (Blueprint $table) {

          $table->increments('id');
          $table->string('name');
          $table->string('net')->nullable();
          $table->enum('driver',['pgsql','mysql'])->nullable()->default(null);
          $table->string('host')->nullable();
          $table->string('port')->nullable();
          $table->string('database')->nullable();
          $table->string('username')->nullable();
          $table->string('password','1000')->nullable();

          $table->boolean('active')->default(true);
          $table->boolean('original_udated')->default(false);
          $table->boolean('filtered_update')->default(false);

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
      Schema::connection('config')->dropIfExists('external_connection');
    }
}
