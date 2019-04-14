<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('alert', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name');
            $table->string('code')->unique();
            $table->string('icon')->nullable();
            $table->string('table')->nullable();
            $table->string('description',500)->nullable();

            $table->boolean('active')->default(false);

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
        Schema::connection('administrator')->dropIfExists('alert');
    }
}
