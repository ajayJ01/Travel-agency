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
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('type')->default('0')->comment('0 - One Way, 1 - Round, 3 - Multi City');
            $table->tinyInteger('class')->default('0')->comment('0 - Economy, 1 - Premium Economy, 3 - Business, 4 - First Class');
            $table->string('email',255)->nullable();
            $table->string('phone',13)->nullable();
            $table->integer('address_id')->nullable();
            $table->integer('no_of_audlts')->default('0');
            $table->integer('no_of_childrens')->default('0');
            $table->integer('no_of_infant')->default('0');
            $table->integer('total_no_of_traveller')->default('0');
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('coupon_code', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('gst_no', 10, 2)->nullable();
            $table->date('booking_date')->nullable();
            $table->tinyInteger('booking_status')->default('0')->comment(' 0 - Panding, 1 - Success, 3 - Cancelled');
            $table->tinyInteger('payment_status')->default('0')->comment('0 - Panding, 1 - Success, 2 - Failed');
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
