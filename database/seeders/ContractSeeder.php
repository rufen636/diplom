<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\User;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем пользователей
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('Нет пользователей для создания договоров. Сначала создайте пользователей.');
            return;
        }

        // Тестовые договоры
        $contracts = [
            [
                'contract_number' => 'ДГ-2024-001',
                'title' => 'Договор на разработку веб-сайта',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(4),
                'amount' => 500000.00,
                'status' => 'active',
                'description' => 'Разработка корпоративного веб-сайта с админ-панелью'
            ],
            [
                'contract_number' => 'ДГ-2024-002',
                'title' => 'Договор на техническую поддержку',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(6),
                'end_date' => now()->addMonths(6),
                'amount' => 300000.00,
                'status' => 'active',
                'description' => 'Ежемесячная техническая поддержка и обслуживание'
            ],
            [
                'contract_number' => 'ДГ-2024-003',
                'title' => 'Договор на разработку мобильного приложения',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(3),
                'end_date' => now()->subDays(10),
                'amount' => 800000.00,
                'status' => 'completed',
                'description' => 'Разработка мобильного приложения для iOS и Android'
            ],
            [
                'contract_number' => 'ДГ-2024-004',
                'title' => 'Договор на дизайн-проектирование',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(2),
                'amount' => 250000.00,
                'status' => 'active',
                'description' => 'Разработка дизайн-концепции и макетов'
            ],
            [
                'contract_number' => 'ДГ-2024-005',
                'title' => 'Договор на консалтинг',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(4),
                'end_date' => now()->subMonths(1),
                'amount' => 150000.00,
                'status' => 'terminated',
                'description' => 'Консультационные услуги по цифровой трансформации'
            ],
            [
                'contract_number' => 'ДГ-2024-006',
                'title' => 'Договор на интеграцию систем',
                'user_id' => $users->random()->id,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addMonths(3),
                'amount' => 600000.00,
                'status' => 'active',
                'description' => 'Интеграция CRM и ERP систем'
            ],
            [
                'contract_number' => 'ДГ-2024-007',
                'title' => 'Договор на хостинг и серверы',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(12),
                'end_date' => now()->addMonths(12),
                'amount' => 180000.00,
                'status' => 'active',
                'description' => 'Годовое обслуживание серверной инфраструктуры'
            ],
            [
                'contract_number' => 'ДГ-2024-008',
                'title' => 'Договор на SEO-оптимизацию',
                'user_id' => $users->random()->id,
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(4),
                'amount' => 200000.00,
                'status' => 'active',
                'description' => 'Комплексная SEO-оптимизация сайта'
            ],
        ];

        foreach ($contracts as $contract) {
            Contract::create($contract);
        }

        $this->command->info('Создано ' . count($contracts) . ' тестовых договоров.');
    }
}
