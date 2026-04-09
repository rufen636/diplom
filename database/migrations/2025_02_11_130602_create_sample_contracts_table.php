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
        Schema::create('sample_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('template_code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('contract_type', ['individual', 'company']);
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->string('version')->default('1.0');
            $table->boolean('is_default')->default(false);

            // Структурированные разделы в формате JSON
            $table->json('sections')->nullable(); // Основные разделы с пунктами
            $table->json('metadata')->nullable(); // Метаданные шаблона
            $table->text('signature_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_contracts');
    }
};
