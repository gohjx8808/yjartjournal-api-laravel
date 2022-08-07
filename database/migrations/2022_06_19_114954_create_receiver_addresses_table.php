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
        Schema::create('receiver_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->string('name');
            $table->unsignedInteger('country_code_id');
            $table->foreign('country_code_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('restrict');
            $table->string('phone_number');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
            $table->string('postcode');
            $table->string('city');
            $table->string('state');
            $table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('_default');
            $table->unsignedInteger('address_tag_id')->nullable();
            $table->foreign('address_tag_id')->references('id')->on('address_tags')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('receiver_addresses');
    }
};
