<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingSeeder extends Seeder
{
    public function run(): void
    {
        $clients = DB::table('provider_clients')->pluck('id');
        $tariffs = DB::table('tariffs')->pluck('id');
        $accountants = DB::table('users')->pluck('id');
        $contracts = DB::table('contracts')->pluck('id');
        $services = DB::table('services')->pluck('id');

        if ($clients->isEmpty() || $tariffs->isEmpty() || $accountants->isEmpty() || $contracts->isEmpty()) {
            $this->command?->warn('Не хватает данных для billings (provider_clients/tariffs/users/contracts).');
            return;
        }

        $now = now();

        DB::table('billings')->insert([
            [
                'billing_number' => 'INV-2026-001',
                'amount' => 650.00,
                'client_id' => $clients->random(),
                'status' => 'pending',
                'description' => 'Счет за услуги связи',
                'note' => null,
                'tax_amount' => 0,
                'tariff_id' => $tariffs->random(),
                'accountant_id' => $accountants->random(),
                'contract_id' => $contracts->random(),
                'billing_date' => now()->toDateString(),
                'invoice_url' => null,
                'due_date' => now()->addDays(10)->toDateString(),
                'paid_date' => null,
                'period_start' => now()->startOfMonth()->toDateString(),
                'period_end' => now()->endOfMonth()->toDateString(),
                'service_id' => $services->isEmpty() ? null : $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'billing_number' => 'INV-2026-002',
                'amount' => 2500.00,
                'client_id' => $clients->random(),
                'status' => 'paid',
                'description' => 'Счет (оплачен)',
                'note' => 'Оплата получена',
                'tax_amount' => null,
                'tariff_id' => $tariffs->random(),
                'accountant_id' => $accountants->random(),
                'contract_id' => $contracts->random(),
                'billing_date' => now()->subDays(5)->toDateString(),
                'invoice_url' => null,
                'due_date' => now()->addDays(5)->toDateString(),
                'paid_date' => now()->subDay()->toDateString(),
                'period_start' => now()->startOfMonth()->toDateString(),
                'period_end' => now()->endOfMonth()->toDateString(),
                'service_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'billing_number' => 'INV-2026-003',
                'amount' => 1100.00,
                'client_id' => $clients->random(),
                'status' => 'created',
                'description' => null,
                'note' => null,
                'tax_amount' => null,
                'tariff_id' => $tariffs->random(),
                'accountant_id' => $accountants->random(),
                'contract_id' => $contracts->random(),
                'billing_date' => null,
                'invoice_url' => null,
                'due_date' => null,
                'paid_date' => null,
                'period_start' => null,
                'period_end' => null,
                'service_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


