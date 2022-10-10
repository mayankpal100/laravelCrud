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
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->integer('property_type_id')->nullable();
            $table->string('county',220)->nullable();
            $table->string('country',220)->nullable();
            $table->string('town',220)->nullable();
            $table->text('description')->nullable();
            $table->string('address',220)->nullable();
            $table->string('image_full',220)->nullable();
            $table->string('image_thumbnail',220)->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->integer('num_bedrooms')->nullable();
            $table->integer('num_bathrooms')->nullable();
            $table->integer('price')->nullable();
            $table->string('type',220)->nullable();
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
        Schema::dropIfExists('properties');
    }
};
