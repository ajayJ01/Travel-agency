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
        Schema::create('flights', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('flight_number',191)->unique();
            $table->string('source');
            $table->string('destination');
            $table->decimal('price', 8, 2);
            $table->timestamp('departure_time');
            $table->timestamp('arrival_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
