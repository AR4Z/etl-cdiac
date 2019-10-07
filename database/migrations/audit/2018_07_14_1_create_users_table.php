<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audit')->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_red')->nullable();
            $table->string('name')->nullable();
            $table->string('rol')->nullable();
            $table->string('email')->nullable()->unique();
            $table->float('minimum_range');
            $table->string('password');


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
        Schema::connection('audit')->dropIfExists('users');
    }
}
