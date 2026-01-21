<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $contractIds = DB::table('contracts')->pluck('id');
        if ($contractIds->isEmpty()) {
            $this->command?->warn('Нет contracts для images (polymorphic).');
            return;
        }

        $now = now();

        DB::table('images')->insert([
            [
                'imageable_type' => \App\Models\Contract::class,
                'imageable_id' => $contractIds->random(),
                'small_uri' => 'storage/app/public/images/sample_small_1.jpg',
                'big_uri' => 'storage/app/public/images/sample_big_1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'imageable_type' => \App\Models\Contract::class,
                'imageable_id' => $contractIds->random(),
                'small_uri' => 'storage/app/public/images/sample_small_2.jpg',
                'big_uri' => 'storage/app/public/images/sample_big_2.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'imageable_type' => \App\Models\Contract::class,
                'imageable_id' => $contractIds->random(),
                'small_uri' => null,
                'big_uri' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


