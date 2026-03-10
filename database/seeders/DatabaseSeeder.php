<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'manager']);
        Role::updateOrCreate(['name' => 'buh']);
        Role::updateOrCreate(['name' => 'sysadmin']);
        $user_manager = User::factory()->create([
            'name' => 'Test User',
            'email' => 'manager@example.com',
        ]);
        $user_manager->assignRole('manager');
        $user_buh = User::factory()->create([
            'name' => 'Test User',
            'email' => 'buh@example.com',
        ]);
        $user_buh->assignRole('buh');
        $user_sysadmin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'sysadmin@example.com',
        ]);
        $user_sysadmin->assignRole('sysadmin');

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
//            SampleContractSeeder::class,
            ImageSeeder::class,
        ]);
//        $this->call([
//            SampleContractSeeder::class,
//        ]);
    }
}
