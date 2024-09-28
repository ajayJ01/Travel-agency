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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 8, 2)->default(0);
            $table->decimal('taxable_amount', 8, 2)->default(0);
            $table->decimal('gst_applied', 8, 2)->default(0);
            $table->decimal('sgst', 8, 2)->default(0);
            $table->decimal('cgst', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->string('payment_method');
            $table->string('transaction_id',191)->unique();
            $table->tinyInteger('transaction_status')->default('0')->comment('0 - Panding, 1 - Success, 2 - Failed');
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
