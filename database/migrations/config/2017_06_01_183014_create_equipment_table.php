<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('equipment_category_id');
            $table->string('name')->unique();
            $table->string('description',500)->nullable();

            $table->timestamps();

            $table->foreign('equipment_category_id')->references('id')->on('equipment_category')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
