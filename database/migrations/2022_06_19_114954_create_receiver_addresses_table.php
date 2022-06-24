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
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('receivers')->onUpdate('cascade')->onDelete('restrict');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
            $table->unsignedInteger('postcode');
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
