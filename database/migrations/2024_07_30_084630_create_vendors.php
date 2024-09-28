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
        Schema::create('vendors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->string('code');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('doc_url')->nullable();
            $table->string('live_credentials')->nullable();
            $table->string('sandbox_credentials')->nullable();
            $table->string('live_url')->nullable();
            $table->string('sandbox_url')->nullable();
            $table->enum('environment',['Sandbox','Live'])->default('Sandbox');
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
