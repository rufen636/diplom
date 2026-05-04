<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $services = DB::table('services')->pluck('id');

        DB::table('equipment')->insert([
            [
                'name' => 'TP-Link Archer C6',
                'price' => 2990.00,
                'description' => 'Wi‑Fi роутер',
                'mac_address' => 'AA:BB:CC:DD:EE:01',
                'ip_address' => '192.168.0.1',
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'MikroTik hAP ac2',
                'price' => 7490.00,
                'description' => 'Wi‑Fi роутер / SOHO',
                'mac_address' => 'AA:BB:CC:DD:EE:02',
                'ip_address' => '192.168.0.2',
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'D-Link DGS-1008D',
                'price' => 1890.00,
                'description' => 'Коммутатор 8 портов',
                'mac_address' => null,
                'ip_address' => null,
                'service_id' => $services->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


