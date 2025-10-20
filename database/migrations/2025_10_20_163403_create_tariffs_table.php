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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название тарифа
            $table->text('description')->nullable(); // Описание
            $table->decimal('price', 10, 2); // Цена
            $table->integer('speed'); // Скорость в Мбит/с
            $table->integer('duration_months')->default(1); // Срок действия в месяцах
            $table->boolean('is_active')->default(true); // Активен ли тариф
            $table->integer('sort_order')->default(0); // Порядок сортировки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
