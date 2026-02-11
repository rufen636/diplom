<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleContractSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('sample_contracts')->insert([
            [
                'template_code' => 'TEMP-INDIVIDUAL-2026',
                'name' => 'Шаблон договора (ФЛ) 2026',
                'description' => 'Базовый шаблон для физических лиц',
                'contract_type' => 'individual',
                'status' => 'active',
                'version' => '1.0',
                'is_default' => true,
                'preamble' => 'Преамбула договора...',
                'subject_of_contract' => 'Предмет договора...',
                'rights_and_obligations' => null,
                'payment_terms' => 'Условия оплаты...',
                'liability' => null,
                'force_majeure' => null,
                'dispute_resolution' => null,
                'confidentiality' => null,
                'other_conditions' => null,
                'signatures_block' => null,
                'clauses' => json_encode(['clause1' => '...']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_code' => 'TEMP-COMPANY-2026',
                'name' => 'Шаблон договора (ЮЛ) 2026',
                'description' => 'Базовый шаблон для юридических лиц',
                'contract_type' => 'company',
                'status' => 'draft',
                'version' => '1.0',
                'is_default' => false,
                'preamble' => null,
                'subject_of_contract' => null,
                'rights_and_obligations' => null,
                'payment_terms' => null,
                'liability' => null,
                'force_majeure' => null,
                'dispute_resolution' => null,
                'confidentiality' => null,
                'other_conditions' => null,
                'signatures_block' => null,
                'clauses' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'template_code' => 'TEMP-ARCHIVE-2025',
                'name' => 'Шаблон договора (архив) 2025',
                'description' => null,
                'contract_type' => 'company',
                'status' => 'archived',
                'version' => '0.9',
                'is_default' => false,
                'preamble' => null,
                'subject_of_contract' => null,
                'rights_and_obligations' => null,
                'payment_terms' => null,
                'liability' => null,
                'force_majeure' => null,
                'dispute_resolution' => null,
                'confidentiality' => null,
                'other_conditions' => null,
                'signatures_block' => null,
                'clauses' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}


