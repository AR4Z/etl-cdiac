<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('administrator')->create('station', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('station_type_id');
            $table->unsignedInteger('net_id');

            # Representa el codigo de la estacion proporcionado por el personal del idea
            $table->string('code')->nullable();

            $table->string('name');
            $table->string('description',500)->nullable();

            # Representa el nombre de la tabla en la central de acopio para la estacion.
            $table->string('table_db_name')->nullable();

            # Reprecenta la cantidad de mediciones por dia para la estación
            $table->integer('measurements_per_day')->nullable();

            #campo de control : representa si la estacion esta en funcionamiento o no.
            $table->boolean('active')->default(true);

            #campo de control : representa si la estacion se debe costrar en el mapa.
            $table->boolean('rt_active')->default(false);

            #campo de control : representa si la estacion tiene proceso de ETL activo.
            $table->boolean('etl_active')->default(false);

            #campo de control: reprecenta si la estacion es comunitaria o no
            $table->boolean('community')->default(false);

            #campo de control : representa el inicio de funcionamiento
            $table->date('start_operation')->nullable();

            #campo de control : representa el final de funcionamiento
            $table->date('finish_operation')->nullable();

            # campos para geolocalizacion
            $table->double('latitude_degrees')->nullable();
            $table->double('latitude_minutes')->nullable();
            $table->double('latitude_seconds')->nullable();
            $table->string('latitude_direction')->nullable();
            $table->double('longitude_degrees')->nullable();
            $table->double('longitude_minutes')->nullable();
            $table->double('longitude_seconds')->nullable();
            $table->string('longitude_direction')->nullable();
            $table->string('city')->nullable();
            $table->string('localization')->nullable();

            $table->string('basin')->nullable();
            $table->string('sub_basin')->nullable();

            # campos de direcciones multimedia
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('pdf_file')->nullable();

            $table->string('comment')->nullable();

            $table->timestamps();

            $table->foreign('station_type_id')->references('id')->on('station_type')->onDelete('cascade');
            $table->foreign('net_id')->references('id')->on('net')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('administrator')->dropIfExists('station');
    }
}
