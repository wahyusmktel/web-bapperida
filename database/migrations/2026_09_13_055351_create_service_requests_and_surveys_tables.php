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
        Schema::create('data_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ticket_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 25);
            $table->string('institution')->nullable();
            $table->string('purpose');
            $table->text('data_description');
            $table->string('status', 20)->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('ikm_surveys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('respondent_type', 50);
            $table->unsignedTinyInteger('rating_service_ease');
            $table->unsignedTinyInteger('rating_speed');
            $table->unsignedTinyInteger('rating_transparency');
            $table->unsignedTinyInteger('rating_satisfaction');
            $table->text('feedback')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikm_surveys');
        Schema::dropIfExists('data_requests');
    }
};
