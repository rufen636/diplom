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
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('provider_clients')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('legal_address')->nullable();
            $table->string('actual_address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('bank_details')->nullable();
            $table->enum('doc_type',['resident card','passport','other'])->default('passport');
            $table->string('identity_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_details');
    }
};
