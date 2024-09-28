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
        Schema::create('connected_flights', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->foreignId('connected_flight_id')->constrained('flights')->onDelete('cascade');
            $table->integer('connection_duration'); // Duration in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connected_flights');
    }
};
