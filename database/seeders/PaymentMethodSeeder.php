<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('payment_methods')->insert([
            ['name' => 'Карта', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Наличные', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Безналичный расчет', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}


