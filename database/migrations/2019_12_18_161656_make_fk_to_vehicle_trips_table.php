<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFkToVehicleTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_trips', function (Blueprint $table) {
            $table->foreign('start_id')->references('id')->on('vehicle_positions')->onDelete('cascade');
            $table->foreign('end_id')->references('id')->on('vehicle_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_trips', function (Blueprint $table) {
            //
            $table->dropForeign(['start_id']);
            $table->dropForeign(['end_id']);
        });
    }
}
