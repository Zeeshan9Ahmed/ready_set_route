<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDailyDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_daily_distances', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->nullable();
            $table->string('total_distance')->nullable();
            $table->string('distance_type')->nullable();
            $table->string('fuel_price')->nullable();
            $table->string('fuel_type')->nullable();
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
        Schema::dropIfExists('driver_daily_distances');
    }
}
