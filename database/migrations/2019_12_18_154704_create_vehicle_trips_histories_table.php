<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTripsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_trips_histories', function (Blueprint $table) {
            $table->bigInteger('trip_id')->unsigned()->nullable();
            $table->bigInteger('position_id')->unsigned()->nullable();

            $table->foreign('trip_id')->references('id')->on('vehicle_trips')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('vehicle_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_trips_histories');
    }
}
