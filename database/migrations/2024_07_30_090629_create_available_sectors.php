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
        Schema::create('available_sectors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('vendor_id');
            $table->string('sector');
            $table->string('origin');
            $table->string('destination');
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_sectors');
    }
};
