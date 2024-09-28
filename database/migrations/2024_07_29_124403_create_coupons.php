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
        Schema::create('coupons', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('coupon_code');
            $table->string('discount_type');
            $table->decimal('discount_value',10, 2)->nullable();
            $table->decimal('minimum_booking_amount',10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('max_usage')->default(0);
            $table->integer('usage_count')->default(0);
            $table->integer('user_restrictions')->nullable();
            $table->string('flight_restrictions')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
