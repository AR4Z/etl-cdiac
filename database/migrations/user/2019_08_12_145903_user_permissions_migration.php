<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPermissionsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('public')->create('user_permission', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id');
            $table->integer('permission_id');

            $table->integer('active_time');
            $table->boolean('active');

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('public')->dropIfExists('user_permission');
    }
}
