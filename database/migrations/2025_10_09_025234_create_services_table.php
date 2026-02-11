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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название услуги');
            $table->string('code')->unique()->comment('Внутренний код услуги');
            $table->text('description')->nullable()->comment('Описание услуги');
            $table->decimal('price', 10, 2)->comment('Базовая цена');
            $table->boolean('is_active')->default(true)->comment('Активна ли услуга');
            $table->boolean('static_ip')->default(false)->comment('Статический IP');
            $table->foreignId('service_category_id')->constrained('service_categories')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('services')->onDelete('cascade')
                ->comment('Родительская услуга для пакетов');
            $table->decimal('internet_speed', 10, 2)->nullable()->comment('Скорость скачивания (Мбит/с)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
