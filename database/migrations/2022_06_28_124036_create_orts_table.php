<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orts', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable();
            $table->enum('status', ['notgoing', 'waiting', 'toSchool', 'toHome','enRoute','droppedOff','absent'])->nullable();
            $table->timestamp("date")->nullable();
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
        Schema::dropIfExists('orts');
    }
}
