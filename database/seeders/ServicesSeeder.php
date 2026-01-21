<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('service_categories')->pluck('id', 'slug');
        if ($categories->isEmpty()) {
            $this->command?->warn('Нет категорий услуг (service_categories). Сначала запустите ServiceCategorySeeder.');
            return;
        }

        $now = now();

        // Сначала создаём корневые услуги (parent_id = null), потом — дочерние.
        $rootServices = [
            [
                'name' => 'Интернет 100 Мбит/с',
                'code' => 'INET-100',
                'description' => 'Домашний интернет до 100 Мбит/с',
                'price' => 650.00,
                'is_active' => true,
                'static_ip' => false,
                'service_category_id' => $categories['internet'],
                'parent_id' => null,
                'internet_speed' => 100,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Интернет 300 Мбит/с',
                'code' => 'INET-300',
                'description' => 'Быстрый интернет до 300 Мбит/с',
                'price' => 2500.00,
                'is_active' => true,
                'static_ip' => true,
                'service_category_id' => $categories['internet'],
                'parent_id' => null,
                'internet_speed' => 300,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SIP-телефония',
                'code' => 'SIP',
                'description' => 'Подключение SIP-телефонии',
                'price' => 499.00,
                'is_active' => true,
                'static_ip' => false,
                'service_category_id' => $categories['telephony'],
                'parent_id' => null,
                'internet_speed' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('services')->insert($rootServices);

        $inet100Id = DB::table('services')->where('code', 'INET-100')->value('id');
        if (!$inet100Id) {
            $this->command?->warn('Не найден service id для INET-100 после вставки.');
            return;
        }

        $childServices = [
            [
                'name' => 'Статический IP (доп.)',
                'code' => 'ADDON-STATIC-IP',
                'description' => 'Выделение статического IP-адреса',
                'price' => 150.00,
                'is_active' => true,
                'static_ip' => true,
                'service_category_id' => $categories['addons'],
                'parent_id' => $inet100Id,
                'internet_speed' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('services')->insert($childServices);
    }
}


