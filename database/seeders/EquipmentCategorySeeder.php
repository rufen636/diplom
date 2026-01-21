<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Сначала родители
        DB::table('equipment_categories')->insert([
            ['name' => 'Маршрутизаторы', 'slug' => 'routers', 'parent_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Коммутаторы', 'slug' => 'switches', 'parent_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Кабели', 'slug' => 'cables', 'parent_id' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $parents = DB::table('equipment_categories')->pluck('id', 'slug');
        if ($parents->isEmpty()) {
            $this->command?->warn('Не удалось получить категории оборудования после вставки.');
            return;
        }

        // Потом дети
        DB::table('equipment_categories')->insert([
            ['name' => 'Wi‑Fi роутеры', 'slug' => 'wifi-routers', 'parent_id' => $parents['routers'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Гигабитные коммутаторы', 'slug' => 'gigabit-switches', 'parent_id' => $parents['switches'], 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}


