<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("actual_mpg")->nullable();
            $table->string("vehicle_model")->nullable();
            $table->string("vehicle_registration")->nullable();
            $table->string("vehicle_type")->nullable();
            $table->string("vehicle_mileage")->nullable();
            $table->string("vin_number")->nullable();
            $table->string("vehicle_company")->nullable();
            $table->string("vehicle_number")->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
