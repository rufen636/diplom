<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_request_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['service_request_id', 'equipment_id']);
        });

        // Миграция данных из equipment_id
        $rows = DB::table('service_requests')->whereNotNull('equipment_id')->get(['id', 'equipment_id']);
        foreach ($rows as $row) {
            DB::table('service_request_equipment')->insert([
                'service_request_id' => $row->id,
                'equipment_id' => $row->equipment_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['equipment_id']);
            $table->dropColumn('equipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->foreignId('equipment_id')->nullable()->after('status')->constrained('equipment');
        });

        $rows = DB::table('service_request_equipment')->get();
        $seen = [];
        foreach ($rows as $row) {
            if (!isset($seen[$row->service_request_id])) {
                $seen[$row->service_request_id] = true;
                DB::table('service_requests')->where('id', $row->service_request_id)->update(['equipment_id' => $row->equipment_id]);
            }
        }

        Schema::dropIfExists('service_request_equipment');
    }
};
