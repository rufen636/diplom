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
            $table->string('template_code')->unique(); // TEMP-INDIVIDUAL-2024
            $table->string('name'); // "Шаблон для физических лиц 2024"
            $table->string('description')->nullable();
            $table->enum('contract_type', ['individual', 'company']);
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->string('version')->default('1.0');
            $table->boolean('is_default')->default(false);
            $table->text('preamble')->nullable(); // Преамбула
            $table->text('subject_of_contract')->nullable(); // Предмет договора
            $table->text('rights_and_obligations')->nullable();
            $table->text('payment_terms')->nullable(); // Условия оплаты
            $table->text('liability')->nullable(); // Ответственность сторон
            $table->text('force_majeure')->nullable(); // Форс-мажор
            $table->text('dispute_resolution')->nullable(); // Разрешение споров
            $table->text('confidentiality')->nullable(); // Конфиденциальность
            $table->text('other_conditions')->nullable(); // Прочие условия
            $table->text('signatures_block')->nullable(); // Блок подписей
            $table->json('clauses')->nullable();
            $table->foreignId('detail_id')->constrained('company_details')->cascadeOnDelete();
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
