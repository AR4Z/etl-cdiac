<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeDimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('time_dim', function (Blueprint $table) {
            $table->increments('time_sk')->unsigned()->unique();
            $table->time('time')->nullable();
            $table->integer('hours');
            $table->integer('minutes');
            $table->integer('seconds');
            $table->enum('part_day', ['madrugada', 'mañana', 'tarde', 'noche'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('time_dim');
    }
}
