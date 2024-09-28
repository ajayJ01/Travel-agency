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
        Schema::create('user_wallet_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id');
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('opening_bal', 10, 2)->nullable();
            $table->decimal('closing_bal', 10, 2)->nullable();
            $table->enum('type', ['dr','cr']);
            $table->string('trx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet_logs');
    }
};
