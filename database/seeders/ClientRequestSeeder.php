<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientRequestSeeder extends Seeder
{
    public function run(): void
    {
        $clients = DB::table('provider_clients')->pluck('id');
        $services = DB::table('services')->pluck('id');

        if ($clients->isEmpty()) {
            $this->command?->warn('Нет клиентов для client_requests (provider_clients).');
            return;
        }

        $now = now();

        DB::table('client_requests')->insert([
            [
                'request_number' => 'REQ-2026-001',
                'priority' => 'medium',
                'status' => 'new',
                'requested_at' => now(),
                'closed_at' => null,
                'client_id' => $clients->random(),
                'service_id' => $services->isEmpty() ? null : $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'request_number' => 'REQ-2026-002',
                'priority' => 'high',
                'status' => 'in_progress',
                'requested_at' => now()->subHours(6),
                'closed_at' => null,
                'client_id' => $clients->random(),
                'service_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'request_number' => 'REQ-2026-003',
                'priority' => 'low',
                'status' => 'closed',
                'requested_at' => now()->subDays(3),
                'closed_at' => now()->subDay(),
                'client_id' => $clients->random(),
                'service_id' => $services->isEmpty() ? null : $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


