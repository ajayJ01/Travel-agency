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
        Schema::create('email_sms_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('act')->nullable();
            $table->string('name')->nullable();
            $table->string('subject')->nullable();
            $table->text('email_body')->nullable();
            $table->string('template_id')->nullable();
            $table->text('sms_body')->nullable();
            $table->text('shortcodes')->nullable();
            $table->tinyInteger('email_status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->tinyInteger('sms_status')->default('1')->comment('1 - Active, 0 - Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_sms_templates');
    }
};
