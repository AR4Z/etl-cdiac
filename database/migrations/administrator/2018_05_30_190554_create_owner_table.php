<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('owner', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name');
            $table->string('code')->unique();
            $table->string('description',500)->nullable();

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
        Schema::connection('administrator')->dropIfExists('owner');
    }
}
