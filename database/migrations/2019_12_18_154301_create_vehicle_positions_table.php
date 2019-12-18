<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('latitude', 14, 10);
            $table->decimal('longitude', 14, 10);
            $table->text('geocoding_address')->nullable();
            $table->integer('speed')->nullable();
            $table->integer('voltage')->nullable();
            $table->integer('distance')->nullable();
            $table->timestamp("tracker_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_positions');
    }
}
