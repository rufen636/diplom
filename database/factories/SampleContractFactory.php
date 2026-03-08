<?php

namespace Database\Factories;

use App\Models\SampleContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SampleContractFactory extends Factory
{
    protected $model = SampleContract::class;

    public function definition(): array
    {
        return [
            'template_code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'contract_type' => $this->faker->word(),
            'status' => $this->faker->word(),
            'version' => $this->faker->word(),
            'is_default' => $this->faker->randomNumber(),
            'preamble' => $this->faker->word(),
            'subject_of_contract' => $this->faker->word(),
            'rights_and_obligations' => $this->faker->word(),
            'payment_terms' => $this->faker->word(),
            'liability' => $this->faker->word(),
            'force_majeure' => $this->faker->word(),
            'dispute_resolution' => $this->faker->word(),
            'confidentiality' => $this->faker->word(),
            'other_conditions' => $this->faker->word(),
            'signatures_block' => $this->faker->word(),
            'clauses' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
