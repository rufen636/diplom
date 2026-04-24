<?php

namespace Tests\Feature\Manager;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TariffsControllerBasicTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);
    }

    public function test_manager_can_create_tariff(): void
    {
        $response = $this->post(route('manager.tariffs.store'), [
            'name' => 'Тариф Старт',
            'description' => 'Базовый тариф',
            'price' => 1200.50,
            'speed' => 100,
            'duration_months' => 12,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('manager.tariffs.index'));

        $this->assertDatabaseHas('tariffs', [
            'name' => 'Тариф Старт',
            'speed' => 100,
        ]);
    }
}

