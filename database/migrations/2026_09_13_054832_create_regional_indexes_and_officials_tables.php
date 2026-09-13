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
        Schema::create('regional_indexes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code', 20)->index();
            $table->unsignedSmallInteger('year')->index();
            $table->decimal('score', 8, 2);
            $table->string('predicate');
            $table->string('evaluator');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('officials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('nip', 30)->nullable();
            $table->string('position');
            $table->string('category_code', 20)->nullable()->index();
            $table->string('photo_path')->nullable();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
        Schema::dropIfExists('regional_indexes');
    }
};
