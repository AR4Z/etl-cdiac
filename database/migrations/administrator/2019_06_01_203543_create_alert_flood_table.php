<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertFloodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('alert_flood', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('basin_id');

            $table->string('name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->boolean('active')->default(true);
            $table->float('limit_red')->nullable();
            $table->string('icon')->nullable();

            $table->foreign('basin_id')->references('id')->on('basin')->onDelete('cascade');

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
        Schema::connection('administrator')->dropIfExists('alert_flood');
    }
}
