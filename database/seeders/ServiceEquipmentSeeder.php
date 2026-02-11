<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $serviceIds = DB::table('services')->pluck('id');
        $equipmentIds = DB::table('equipment')->pluck('id');

        if ($serviceIds->isEmpty() || $equipmentIds->isEmpty()) {
            $this->command?->warn('Не хватает services/equipment для заполнения pivot service_equipment.');
            return;
        }

        $now = now();

        // Минимально: привяжем 3 связки (если записей меньше — аккуратно ограничим)
        $rows = [];
        foreach ($serviceIds->take(3) as $sid) {
            $rows[] = [
                'service_id' => $sid,
                'equipment_id' => $equipmentIds->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('service_equipment')->insert($rows);
    }
}


