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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('booking_id');
            $table->integer('flight_id');
            $table->string('source',255)->nullable();
            $table->string('destination',255)->nullable();
            $table->date('departure_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->date('arrival_date')->nullable();
            $table->time('arrival_time')->nullable();
            $table->integer('no_of_ticket')->nullable();
            $table->decimal('price',10,2)->default(0);
            $table->tinyInteger('class')->default('0')->comment('0 - Economy, 1 - Premium Economy, 3 - Business, 4 - First Class');
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
