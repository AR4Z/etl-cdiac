<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('public')->create('role', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('code')->unique();
            $table->string('name');
            $table->string('description',250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('public')->dropIfExists('role');
    }
}
