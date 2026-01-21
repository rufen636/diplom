<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Создаем дополнительные пользователей для теста
        User::factory(5)->create();

        // Доменные сиды (важен порядок из-за FK)
        $this->call([
            ServiceCategorySeeder::class,
            ServicesSeeder::class,
            TariffSeeder::class,
            ProviderClientSeeder::class,
            ContractSeeder::class,
            BillingSeeder::class,
            ClientRequestSeeder::class,
            PaymentMethodSeeder::class,
            NetworkMapSeeder::class,
            EquipmentCategorySeeder::class,
            EquipmentSeeder::class,
            ServiceEquipmentSeeder::class,
            BuhActSeeder::class,
            SampleContractSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
