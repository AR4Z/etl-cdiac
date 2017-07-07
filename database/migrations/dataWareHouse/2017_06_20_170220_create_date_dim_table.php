<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateDimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('date_dim', function (Blueprint $table) {
            $table->increments('date_sk')->unsigned()->unique();
            $table->date('date');
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('week_day');
            $table->integer('week_year');
            $table->integer('quarter');
            $table->integer('semester');
            $table->string('lustrum');
            $table->string('month_name');
            $table->string('day_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('date_dim');
    }
}
