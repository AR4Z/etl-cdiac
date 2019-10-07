<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleAplicationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('public')->create('role_application', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('role_id');
            $table->integer('application_id');

            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
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
