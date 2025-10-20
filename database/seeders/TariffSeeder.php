<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tariffs = [
            [
                'name' => 'Базовый 50',
                'description' => 'Базовый тариф для домашнего использования. Идеально подходит для просмотра видео, работы в интернете и общения в социальных сетях.',
                'price' => 450.00,
                'speed' => 50,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Стандарт 100',
                'description' => 'Популярный тариф для активных пользователей. Обеспечивает комфортную работу с несколькими устройствами одновременно, просмотр видео в высоком качестве.',
                'price' => 650.00,
                'speed' => 100,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Комфорт 150',
                'description' => 'Комфортный тариф для семейного использования. Поддерживает одновременную работу большого количества устройств, онлайн-игры, стриминг.',
                'price' => 850.00,
                'speed' => 150,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Премиум 200',
                'description' => 'Премиальный тариф для требовательных пользователей. Максимальная скорость для профессиональной работы, онлайн-игр и развлечений.',
                'price' => 1100.00,
                'speed' => 200,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Бизнес 300',
                'description' => 'Корпоративный тариф для малого и среднего бизнеса. Обеспечивает стабильную работу офисных приложений, видеоконференций, облачных сервисов.',
                'price' => 2500.00,
                'speed' => 300,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Бизнес 500',
                'description' => 'Профессиональный тариф для среднего бизнеса. Высокая скорость и стабильность для работы с большими объемами данных, видеоконференций, CRM-систем.',
                'price' => 4500.00,
                'speed' => 500,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Корпоративный 1000',
                'description' => 'Корпоративный тариф для крупных организаций. Максимальная скорость для работы с критически важными приложениями и сервисами.',
                'price' => 8500.00,
                'speed' => 1000,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Эконом 25',
                'description' => 'Экономичный тариф для базовых потребностей. Подходит для просмотра сайтов, социальных сетей, легкого серфинга в интернете.',
                'price' => 300.00,
                'speed' => 25,
                'duration_months' => 1,
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'Годовой 100',
                'description' => 'Специальное предложение при оплате на год вперед. Тариф 100 Мбит/с с существенной скидкой за предоплату.',
                'price' => 6000.00,
                'speed' => 100,
                'duration_months' => 12,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Ночной 200',
                'description' => 'Специальный тариф с неограниченным трафиком в ночное время с 00:00 до 08:00. Днем действует ограничение 50 Мбит/с.',
                'price' => 750.00,
                'speed' => 200,
                'duration_months' => 1,
                'is_active' => false,
                'sort_order' => 9,
            ],
        ];

        foreach ($tariffs as $tariff) {
            Tariff::create($tariff);
        }
    }
}
