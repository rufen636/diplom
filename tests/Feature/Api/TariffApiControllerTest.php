<?php

namespace Tests\Feature\Api;

use App\Models\Tariff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TariffApiControllerTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'name' => 'API Tariff',
            'description' => 'Test',
            'price' => 500,
            'speed' => 50,
            'duration_months' => 3,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function test_guest_cannot_list_tariffs(): void
    {
        $this->getJson('/api/v1/tariffs')->assertUnauthorized();
    }

    public function test_authenticated_user_gets_json_tariff_list(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Tariff::create(array_merge($this->validPayload(), ['user_id' => $user->id]));

        $response = $this->getJson('/api/v1/tariffs');

        $response->assertOk()
            ->assertJsonPath('data.0.name', 'API Tariff');
    }

    public function test_post_creates_tariff(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/tariffs', $this->validPayload());

        $response->assertCreated()
            ->assertJsonPath('data.name', 'API Tariff');

        $this->assertDatabaseHas('tariffs', [
            'user_id' => $user->id,
            'name' => 'API Tariff',
        ]);
    }

    public function test_patch_updates_own_tariff(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $tariff = Tariff::create(array_merge($this->validPayload(), ['user_id' => $user->id]));

        $response = $this->patchJson('/api/v1/tariffs/'.$tariff->id, array_merge($this->validPayload(), [
            'name' => 'Updated',
        ]));

        $response->assertOk()->assertJsonPath('data.name', 'Updated');
        $this->assertDatabaseHas('tariffs', ['id' => $tariff->id, 'name' => 'Updated']);
    }

    public function test_delete_removes_own_tariff(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $tariff = Tariff::create(array_merge($this->validPayload(), ['user_id' => $user->id]));

        $this->deleteJson('/api/v1/tariffs/'.$tariff->id)->assertNoContent();

        $this->assertDatabaseMissing('tariffs', ['id' => $tariff->id]);
    }
}
