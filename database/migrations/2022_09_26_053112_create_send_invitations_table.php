<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_invitations', function (Blueprint $table) {
            $table->id();
            $table->morphs('sender');
            $table->string('name')->nullable();
            $table->enum('invite-to', ['county', 'school', 'teacher'])->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('location')->nullable();
            $table->string('code')->nullable();
            $table->integer('county_id')->nullable();
            $table->text('invite_link')->nullable();
            $table->enum('status', ['accepted', 'pending'])->default('pending');
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
        Schema::dropIfExists('send_invitations');
    }
}
