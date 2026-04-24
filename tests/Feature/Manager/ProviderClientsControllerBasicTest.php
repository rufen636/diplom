<?php

namespace Tests\Feature\Manager;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderClientsControllerBasicTest extends TestCase
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

    public function test_manager_can_create_provider_client_with_details(): void
    {
        $response = $this->post(route('manager.provider-clients.store'), [
            'name' => 'ООО Альфа',
            'contact_person' => 'Иванов Иван Иванович',
            'email' => 'alpha@example.com',
            'phone' => '+79990001122',
            'type' => 'company',
            'address' => 'г. Москва, ул. Ленина, д. 1',
            'status' => 'active',
            'notes' => 'Тестовый клиент',
            'client_details' => [
                'full_name' => 'ООО Альфа',
                'legal_address' => 'г. Москва, ул. Ленина, д. 1',
                'inn' => '7701234567',
                'kpp' => '770101001',
                'actual_address' => 'г. Москва, ул. Ленина, д. 1',
                'phone' => '+79990001122',
                'email' => 'alpha@example.com',
                'bank_details' => 'р/с 40702810000000000001 в ПАО Банк',
                'doc_type' => 'other',
                'identity_number' => 'N/A',
            ],
        ]);

        $response->assertRedirect(route('manager.provider-clients.index'));

        $this->assertDatabaseHas('provider_clients', [
            'name' => 'ООО Альфа',
            'email' => 'alpha@example.com',
            'type' => 'company',
        ]);

        $this->assertDatabaseHas('client_details', [
            'full_name' => 'ООО Альфа',
            'inn' => '7701234567',
        ]);
    }
}

