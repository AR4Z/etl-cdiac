<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryFactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('data_warehouse')->create('inventory_fact', function (Blueprint $table) {
            $table->bigInteger('source_sk')->unsigned();
            $table->bigInteger('date_sk')->unsigned();

            $table->decimal('co', 10, 4)->nullable();
            $table->decimal('nox', 10, 4)->nullable();
            $table->decimal('sox', 10, 4)->nullable();
            $table->decimal('pm10', 10, 4)->nullable();
            $table->decimal('tsp', 10, 4)->nullable();
            $table->decimal('voc', 10, 4)->nullable();
            $table->decimal('metals', 10, 4)->nullable();
            $table->decimal('co2', 10, 4)->nullable();
            $table->decimal('ch4', 10, 4)->nullable();
            $table->decimal('n2o', 10, 4)->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->longText('comment')->nullable();

            $table->primary(['source_sk', 'date_sk'], 'inventory_fact_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('data_warehouse')->dropIfExists('inventory_fact');
    }
}
