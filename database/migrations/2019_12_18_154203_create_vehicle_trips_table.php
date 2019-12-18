<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id')->unsigned();
            $table->bigInteger('start_id')->unsigned()->nullable();
            $table->bigInteger('end_id')->unsigned()->nullable();
            $table->integer('distance')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('max_speed')->nullable();
            $table->integer('average_speed')->nullable();
            $table->integer('idle_duration')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_trips');
    }
}
