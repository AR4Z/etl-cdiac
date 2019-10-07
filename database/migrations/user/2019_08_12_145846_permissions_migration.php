<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('public')->create('permissions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('code')->unique();
            $table->string('name');
            $table->string('description',250);
            $table->integer('application_id');
            $table->integer('role_id');

            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('public')->dropIfExists('permissions');
    }
}
