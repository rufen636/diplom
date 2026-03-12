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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('provider_clients')->cascadeOnDelete();
            $table->foreignId('sample_contract_id')->constrained()->cascadeOnDelete();
            $table->string('installation_address')->nullable();
            $table->enum('status', ['created', 'accepted', 'on_inspection','archived'])->default('created');
            $table->foreignId('equipment_id')->nullable()->constrained('equipment');
            $table->foreignId('assigned_by')->nullable()->constrained('users'); // sysadmin
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
