<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->integer("sender_id")->nullable();
            $table->enum('sender_type', ['admin', 'teacher', 'user', 'driver', 'school'])->nullable();

            $table->integer("reciever_id")->nullable();
            $table->enum('reciever_type', ['admin', 'teacher', 'user', 'driver', 'school'])->nullable();

            $table->string("message");
            $table->timestamp("unread")->nullable();
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
        Schema::dropIfExists('chats');
    }
}
