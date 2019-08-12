<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserMigration extends Migration
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
            $table->integer('role_id');

            $table->string('name',50);
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('identification_document',50)->unique();
            $table->longText('password');
            $table->string('institution');
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
