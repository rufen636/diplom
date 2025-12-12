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
        Schema::create('client_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium')->comment('Приоритет заявки');
            $table->enum('status', ['new', 'in_progress', 'on_hold', 'resolved', 'cancelled', 'closed'])->default('new')->comment('Статус заявки');
            $table->timestamp('requested_at')->useCurrent()->comment('Дата и время создания заявки');
            $table->timestamp('closed_at')->nullable()->comment('Дата и время закрытия');
            $table->foreignId('client_id')->constrained('provider_clients')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_requests');
    }
};
