<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuhActSeeder extends Seeder
{
    public function run(): void
    {
        $clients = DB::table('provider_clients')->pluck('id');
        $contracts = DB::table('contracts')->pluck('id');

        if ($clients->isEmpty() || $contracts->isEmpty()) {
            $this->command?->warn('Не хватает provider_clients/contracts для buh_acts.');
            return;
        }

        $now = now();

        DB::table('buh_acts')->insert([
            [
                'act_number' => 'ACT-2026-001',
                'act_date' => now()->subDays(10)->toDateString(),
                'act_type' => 'monthly',
                'status' => 'sent',
                'description' => 'Акт за услуги связи за прошлый период',
                'client_id' => $clients->random(),
                'contract_id' => $contracts->random(),
                'amount' => 650.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'act_number' => 'ACT-2026-002',
                'act_date' => now()->subDays(3)->toDateString(),
                'act_type' => 'one-time',
                'status' => 'draft',
                'description' => null,
                'client_id' => $clients->random(),
                'contract_id' => $contracts->random(),
                'amount' => 2500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'act_number' => 'ACT-2026-003',
                'act_date' => now()->toDateString(),
                'act_type' => 'additional',
                'status' => 'paid',
                'description' => 'Дополнительные работы',
                'client_id' => $clients->random(),
                'contract_id' => $contracts->random(),
                'amount' => 1100.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


