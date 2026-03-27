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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('billing_number');
            $table->double('amount');
            $table->foreignId('client_id')->constrained('provider_clients')->onDelete('cascade');
            $table->enum('status', ['created','pending', 'paid', 'completed','expired'])->default('pending');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->double('tax_amount')->nullable();
            $table->foreignId('tariff_id')->constrained('tariffs')->onDelete('cascade');
            $table->foreignId('accountant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->date('billing_date')->nullable()->comment('Дата формирования счета');
            $table->string('invoice_url')->nullable();
            $table->date('due_date')->nullable()->comment('Срок оплаты');
            $table->date('paid_date')->nullable()->comment('Дата оплаты');
            $table->date('period_start')->nullable()->comment('Начало расчетного периода');
            $table->date('period_end')->nullable()->comment('Конец расчетного периода');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
