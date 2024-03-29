<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('variable', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();
            $table->string('excel_name')->nullable();
            $table->string('database_field_name')->nullable();
            $table->string('local_name')->nullable();
            $table->string('reliability_name')->nullable();
            $table->integer('decimal_precision')->default(0);
            $table->string('unit',50)->nullable();
            $table->string('correct_serialization',50)->nullable();
            $table->string('report_name')->nullable();

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
        Schema::connection('administrator')->dropIfExists('variable');
    }
}
