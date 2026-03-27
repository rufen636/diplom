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
        Schema::create('buh_acts', function (Blueprint $table) {
            $table->id();
            $table->string('act_number')->unique(); // ACT-2024-001
            $table->date('act_date'); // Date of act creation
            $table->enum('act_type', ['monthly', 'one-time', 'correction', 'additional']); // Types of acts
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->constrained('provider_clients')->onDelete('restrict');
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('restrict');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buh_acts');
    }
};
