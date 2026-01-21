<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NetworkMapSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('network_maps')->insert([
            [
                'name' => 'Узел Москва Центр',
                'latitude' => '55.7558',
                'longitude' => '37.6176',
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Узел Москва Север',
                'latitude' => '55.8600',
                'longitude' => '37.6000',
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Узел Москва Юг',
                'latitude' => '55.6500',
                'longitude' => '37.6000',
                'is_available' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


