<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('information_request', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('comment',500)->nullable();
            $table->string('subject')->nullable();
            $table->string('information_use')->nullable();
            $table->string('purpose')->nullable();
            $table->date('creation_date')->nullable();
            $table->date('answer_date')->nullable();
            $table->string('petitioner_name')->nullable();
            $table->string('petitioner_email')->nullable();
            $table->string('petitioner_entity')->nullable();
            $table->string('petitioner_phone')->nullable();
            $table->string('petitioner_occupation')->nullable();
            $table->string('petitioner_profession')->nullable();

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
        Schema::connection('administrator')->dropIfExists('information_request');
    }
}
