<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('passenger_details', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('booking_id');
            $table->enum('type',['adult','infant','child'])->default('adult');
            $table->enum('title',['Mr','Mrs','Miss','Ms','Mstr'])->default('Mr');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_num')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passenger_details');
    }
};
