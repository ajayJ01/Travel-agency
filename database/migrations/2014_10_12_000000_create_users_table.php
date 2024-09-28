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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('role');
            $table->string('name',191)->nullable();
            $table->string('email',191)->unique()->nullable();
            $table->string('country_code',191)->nullable();
            $table->string('phone_no',191)->unique();
            $table->string('image',255)->nullable();
            $table->string('password')->nullable();
            $table->longText('address')->nullable();
            $table->rememberToken()->nullable();
            $table->enum('device_type',['android', 'ios', 'web'])->nullable();
            $table->longtext('device_id')->nullable();
            $table->longtext('fcm_token')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
