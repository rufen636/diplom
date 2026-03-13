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
        Schema::create('network_maps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_available')->default(false);
            $table->string('address')->nullable();
            $table->decimal('coverage_radius', 5, 2)->default(10);
            $table->json('technical_info')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('current_load')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_maps');
    }
};
