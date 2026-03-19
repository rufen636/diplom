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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->string('title');
            $table->foreignId('client_id')->constrained('provider_clients')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['active', 'completed', 'terminated','pending'])->default('active');
            $table->enum('payment_status', ['paid', 'not_paid', 'pending','billing_issued'])->default('not_paid');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('sample_id')->nullable()->constrained('sample_contracts')->onDelete('cascade');
            $table->foreignId('service_request_id')->nullable()->constrained('service_requests')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
