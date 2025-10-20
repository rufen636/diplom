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
        Schema::create('provider_clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // Название компании
            $table->string('contact_person'); // Контактное лицо
            $table->string('email')->unique(); // Email
            $table->string('phone'); // Телефон
            $table->text('address')->nullable(); // Адрес
            $table->string('inn')->nullable(); // ИНН
            $table->string('kpp')->nullable(); // КПП
            $table->string('status')->default('active'); // Статус: active, inactive, blocked
            $table->text('notes')->nullable(); // Заметки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_clients');
    }
};
