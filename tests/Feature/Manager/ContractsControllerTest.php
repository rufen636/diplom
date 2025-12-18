<?php

namespace Tests\Feature\Manager;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = User::factory()->create(['role' => 'manager']);
        $this->actingAs($this->manager);
    }

    /** @test */
    public function it_can_display_contracts_index_page()
    {
        Contract::factory()->count(5)->create();

        $response = $this->get(route('manager.contracts.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Contracts/Index')
            ->has('contracts.data', 5)
        );
    }

    /** @test */
    public function it_can_filter_contracts_by_search()
    {
        $contract1 = Contract::factory()->create(['contract_number' => 'CONTRACT-001']);
        $contract2 = Contract::factory()->create(['contract_number' => 'OTHER-002']);

        $response = $this->get(route('manager.contracts.index', ['search' => 'CONTRACT']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Contracts/Index')
            ->has('contracts.data', 1)
            ->where('contracts.data.0.contract_number', 'CONTRACT-001')
        );
    }

    /** @test */
    public function it_can_filter_contracts_by_status()
    {
        Contract::factory()->create(['status' => 'active']);
        Contract::factory()->create(['status' => 'completed']);

        $response = $this->get(route('manager.contracts.index', ['status' => 'active']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Contracts/Index')
            ->has('contracts.data', 1)
            ->where('contracts.data.0.status', 'active')
        );
    }

    /** @test */
    public function it_can_display_contract_create_page()
    {
        $response = $this->get(route('manager.contracts.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Contracts/Create')
            ->has('users')
        );
    }

    /** @test */
    public function it_can_store_new_contract()
    {
        $user = User::factory()->create();

        $data = [
            'contract_number' => 'CONTRACT-2023-001',
            'title' => 'Test Contract',
            'user_id' => $user->id,
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
            'amount' => 1000.50,
            'status' => 'active',
            'description' => 'Test description',
        ];

        $response = $this->post(route('manager.contracts.store'), $data);

        $response->assertRedirect(route('manager.contracts.index'));
        $this->assertDatabaseHas('contracts', [
            'contract_number' => 'CONTRACT-2023-001',
            'title' => 'Test Contract',
        ]);
    }

    /** @test */
    public function it_validates_contract_store_request()
    {
        $response = $this->post(route('manager.contracts.store'), []);

        $response->assertSessionHasErrors([
            'contract_number', 'title', 'user_id', 'start_date', 'end_date', 'amount', 'status'
        ]);
    }

    /** @test */
    public function it_validates_end_date_is_after_start_date()
    {
        $user = User::factory()->create();

        $data = [
            'contract_number' => 'CONTRACT-2023-001',
            'title' => 'Test Contract',
            'user_id' => $user->id,
            'start_date' => '2023-12-31',
            'end_date' => '2023-01-01',
            'amount' => 1000.50,
            'status' => 'active',
        ];

        $response = $this->post(route('manager.contracts.store'), $data);

        $response->assertSessionHasErrors('end_date');
    }

    /** @test */
    public function it_can_display_contract_edit_page()
    {
        $contract = Contract::factory()->create();

        $response = $this->get(route('manager.contracts.edit', $contract));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Contracts/Edit')
            ->has('contract')
            ->has('users')
        );
    }

    /** @test */
    public function it_can_update_contract()
    {
        $contract = Contract::factory()->create(['title' => 'Old Title']);
        $newUser = User::factory()->create();

        $data = [
            'contract_number' => $contract->contract_number,
            'title' => 'Updated Title',
            'user_id' => $newUser->id,
            'start_date' => $contract->start_date->format('Y-m-d'),
            'end_date' => $contract->end_date->format('Y-m-d'),
            'amount' => 2000.00,
            'status' => 'completed',
            'description' => 'Updated description',
        ];

        $response = $this->put(route('manager.contracts.update', $contract), $data);

        $response->assertRedirect(route('manager.contracts.index'));
        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'title' => 'Updated Title',
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function it_can_delete_contract()
    {
        $contract = Contract::factory()->create();

        $response = $this->delete(route('manager.contracts.destroy', $contract));

        $response->assertRedirect(route('manager.contracts.index'));
        $this->assertDatabaseMissing('contracts', ['id' => $contract->id]);
    }

    /** @test */
    public function it_validates_unique_contract_number_on_update()
    {
        $contract1 = Contract::factory()->create(['contract_number' => 'CONTRACT-001']);
        $contract2 = Contract::factory()->create(['contract_number' => 'CONTRACT-002']);

        $data = [
            'contract_number' => 'CONTRACT-001', // Дублирующийся номер
            'title' => 'Updated Title',
            'user_id' => $contract2->user_id,
            'start_date' => $contract2->start_date->format('Y-m-d'),
            'end_date' => $contract2->end_date->format('Y-m-d'),
            'amount' => 1000.50,
            'status' => 'active',
        ];

        $response = $this->put(route('manager.contracts.update', $contract2), $data);

        $response->assertSessionHasErrors('contract_number');
    }
}
