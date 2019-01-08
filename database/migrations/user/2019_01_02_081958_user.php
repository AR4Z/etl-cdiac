<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('public')->create('user', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name',50);
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('identification_document',50)->unique();
            $table->longText('password');
            $table->string('username')->unique();
            $table->string('institution');
            $table->integer('role_id');
            $table->boolean('active')->default(false);
            $table->boolean('confirm')->default(false);
            $table->string('confirmed_code');
            $table->string('encrypt');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('public')->dropIfExists('user');
    }
}
