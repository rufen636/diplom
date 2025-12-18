<?php

namespace Tests\Feature\Manager;

use App\Models\Tariff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TariffsControllerTest extends TestCase
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
    public function it_can_display_tariffs_index_page()
    {
        Tariff::factory()->count(5)->create();

        $response = $this->get(route('manager.tariffs.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Index')
            ->has('tariffs.data', 5)
        );
    }

    /** @test */
    public function it_can_filter_tariffs_by_search()
    {
        Tariff::factory()->create(['name' => 'Premium Tariff']);
        Tariff::factory()->create(['name' => 'Basic Tariff']);

        $response = $this->get(route('manager.tariffs.index', ['search' => 'Premium']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Index')
            ->has('tariffs.data', 1)
            ->where('tariffs.data.0.name', 'Premium Tariff')
        );
    }

    /** @test */
    public function it_can_filter_tariffs_by_active_status()
    {
        Tariff::factory()->create(['is_active' => true]);
        Tariff::factory()->create(['is_active' => false]);

        $response = $this->get(route('manager.tariffs.index', ['status' => 'active']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Index')
            ->has('tariffs.data', 1)
            ->where('tariffs.data.0.is_active', true)
        );
    }

    /** @test */
    public function it_can_filter_tariffs_by_inactive_status()
    {
        Tariff::factory()->create(['is_active' => true]);
        Tariff::factory()->create(['is_active' => false]);

        $response = $this->get(route('manager.tariffs.index', ['status' => 'inactive']));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Index')
            ->has('tariffs.data', 1)
            ->where('tariffs.data.0.is_active', false)
        );
    }

    /** @test */
    public function it_can_display_tariff_create_page()
    {
        $response = $this->get(route('manager.tariffs.create'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Create')
        );
    }

    /** @test */
    public function it_can_store_new_tariff()
    {
        $data = [
            'name' => 'Premium Tariff',
            'description' => 'Premium tariff description',
            'price' => 999.99,
            'speed' => 100,
            'duration_months' => 12,
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->post(route('manager.tariffs.store'), $data);

        $response->assertRedirect(route('manager.tariffs.index'));
        $this->assertDatabaseHas('tariffs', [
            'name' => 'Premium Tariff',
            'price' => 999.99,
            'speed' => 100,
        ]);
    }

    /** @test */
    public function it_validates_tariff_store_request()
    {
        $response = $this->post(route('manager.tariffs.store'), []);

        $response->assertSessionHasErrors([
            'name', 'price', 'speed', 'duration_months'
        ]);
    }

    /** @test */
    public function it_validates_price_is_positive()
    {
        $data = [
            'name' => 'Premium Tariff',
            'price' => -100,
            'speed' => 100,
            'duration_months' => 12,
        ];

        $response = $this->post(route('manager.tariffs.store'), $data);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function it_validates_speed_is_positive_integer()
    {
        $data = [
            'name' => 'Premium Tariff',
            'price' => 100,
            'speed' => 0,
            'duration_months' => 12,
        ];

        $response = $this->post(route('manager.tariffs.store'), $data);

        $response->assertSessionHasErrors('speed');
    }

    /** @test */
    public function it_can_display_tariff_edit_page()
    {
        $tariff = Tariff::factory()->create();

        $response = $this->get(route('manager.tariffs.edit', $tariff));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Manager/Tariffs/Edit')
            ->has('tariff')
        );
    }

    /** @test */
    public function it_can_update_tariff()
    {
        $tariff = Tariff::factory()->create(['price' => 100]);

        $data = [
            'name' => 'Updated Tariff',
            'description' => 'Updated description',
            'price' => 200,
            'speed' => 200,
            'duration_months' => 24,
            'is_active' => false,
            'sort_order' => 2,
        ];

        $response = $this->put(route('manager.tariffs.update', $tariff), $data);

        $response->assertRedirect(route('manager.tariffs.index'));
        $this->assertDatabaseHas('tariffs', [
            'id' => $tariff->id,
            'name' => 'Updated Tariff',
            'price' => 200,
            'is_active' => false,
        ]);
    }

    /** @test */
    public function it_can_delete_tariff()
    {
        $tariff = Tariff::factory()->create();

        $response = $this->delete(route('manager.tariffs.destroy', $tariff));

        $response->assertRedirect(route('manager.tariffs.index'));
        $this->assertDatabaseMissing('tariffs', ['id' => $tariff->id]);
    }

    /** @test */
    public function it_accepts_nullable_sort_order()
    {
        $data = [
            'name' => 'Premium Tariff',
            'price' => 100,
            'speed' => 100,
            'duration_months' => 12,
            'sort_order' => null,
        ];

        $response = $this->post(route('manager.tariffs.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('tariffs', [
            'name' => 'Premium Tariff',
            'sort_order' => null,
        ]);
    }
}
