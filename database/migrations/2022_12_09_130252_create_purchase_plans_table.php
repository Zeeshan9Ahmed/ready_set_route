<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_type');
            $table->integer('plan_id');
            $table->double('price');
            $table->enum('is_discounted_price', ['0','1'])->default('0');
            $table->text('stripe_token')->nullable();
            $table->text('stripe_id')->nullable();
            $table->text('stripe_status')->nullable();
            $table->text('stripe_price')->nullable();
            $table->text('currency')->nullable();
            $table->text('quantity')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('receipt_url')->nullable();
            $table->enum('is_expire', ['0','1'])->default('0');
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
        Schema::dropIfExists('purchase_plans');
    }
}
