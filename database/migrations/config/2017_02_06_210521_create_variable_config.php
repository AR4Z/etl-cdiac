<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariableTableConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('config')->create('variable', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('name_excel')->nullable();
          $table->string('name_database')->nullable();
          $table->string('name_locale')->nullable();

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
        Schema::connection('config')->dropIfExists('variable');
    }
}
