<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleApplicationUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_application', function (Blueprint $table) {
            $table->integer('user_id');
            $table->date('from')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->date('until')->nullable();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_application', function (Blueprint $table) {
            //
        });
    }
}
