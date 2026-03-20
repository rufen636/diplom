<?php

namespace Database\Seeders;

use App\Models\ProviderClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем пользователей
        $users = User::query()->pluck('id');
        $clients = ProviderClient::query()->pluck('id');
        $services = DB::table('services')->pluck('id');

        if ($users->isEmpty()) {
            $this->command->warn('Нет пользователей для создания договоров. Сначала создайте пользователей.');
            return;
        }
        if ($clients->isEmpty()) {
            $this->command->warn('Нет клиентов для создания договоров. Сначала создайте клиентов (provider_clients).');
            return;
        }
        if ($services->isEmpty()) {
            $this->command->warn('Нет услуг для создания договоров. Сначала создайте услуги (services).');
            return;
        }

        $now = now();
        // Тестовые договоры
        $contracts = [
            [
                'contract_number' => 'ДГ-2024-001',
                'title' => 'Договор на разработку веб-сайта',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(4),
                'amount' => 500000.00,
                'status' => 'active',
                'description' => 'Разработка корпоративного веб-сайта с админ-панелью',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-002',
                'title' => 'Договор на техническую поддержку',
                'start_date' => now()->subMonths(6),
                'end_date' => now()->addMonths(6),
                'amount' => 300000.00,
                'status' => 'active',
                'description' => 'Ежемесячная техническая поддержка и обслуживание',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-003',
                'title' => 'Договор на разработку мобильного приложения',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->subDays(10),
                'amount' => 800000.00,
                'status' => 'completed',
                'description' => 'Разработка мобильного приложения для iOS и Android',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,

            ],
            [
                'contract_number' => 'ДГ-2024-004',
                'title' => 'Договор на дизайн-проектирование',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(2),
                'amount' => 250000.00,
                'status' => 'active',
                'description' => 'Разработка дизайн-концепции и макетов',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-005',
                'title' => 'Договор на консалтинг',
                'start_date' => now()->subMonths(4),
                'end_date' => now()->subMonths(1),
                'amount' => 150000.00,
                'status' => 'terminated',
                'description' => 'Консультационные услуги по цифровой трансформации',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-006',
                'title' => 'Договор на интеграцию систем',
                'start_date' => now()->subDays(15),
                'end_date' => now()->addMonths(3),
                'amount' => 600000.00,
                'status' => 'active',
                'description' => 'Интеграция CRM и ERP систем',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-007',
                'title' => 'Договор на хостинг и серверы',
                'start_date' => now()->subMonths(12),
                'end_date' => now()->addMonths(12),
                'amount' => 180000.00,
                'status' => 'active',
                'description' => 'Годовое обслуживание серверной инфраструктуры',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'contract_number' => 'ДГ-2024-008',
                'title' => 'Договор на SEO-оптимизацию',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(4),
                'amount' => 200000.00,
                'status' => 'active',
                'description' => 'Комплексная SEO-оптимизация сайта',
                'client_id' => $clients->random(),
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('contracts')->insert($contracts);

        $this->command->info('Создано ' . count($contracts) . ' тестовых договоров.');
    }
}
