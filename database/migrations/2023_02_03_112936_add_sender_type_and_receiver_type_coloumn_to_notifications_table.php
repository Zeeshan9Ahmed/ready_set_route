<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderTypeAndReceiverTypeColoumnToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('sender_type', ['admin', 'county', 'parent','student','teacher', 'all', 'driver', 'school'])->nullable();
            $table->enum('reciever_type', ['admin','county', 'parent','student',  'teacher', 'all', 'driver', 'school'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
        });
    }
}
