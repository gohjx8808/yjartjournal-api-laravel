<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedInteger('receiver_address_id');
            $table->foreign('receiver_address_id')->references('id')->on('receiver_addresses')->onDelete('restrict');
            $table->unsignedFloat('shipping_fee')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedInteger('promo_code_id')->nullable();
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('payment_option_id');
            $table->foreign('payment_option_id')->references('id')->on('payment_options')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedFloat('total_price');
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
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
        Schema::dropIfExists('user_orders');
    }
};
