<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('service_categories')->insert([
            [
                'name' => 'Интернет',
                'slug' => 'internet',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Телефония',
                'slug' => 'telephony',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Дополнительные услуги',
                'slug' => 'addons',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


