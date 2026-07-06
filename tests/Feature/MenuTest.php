<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->owner()->create([
            'password' => 'password',
        ]);
    }

    public function test_owner_can_view_menu_index(): void
    {
        $this->actingAs($this->owner);

        $response = $this->get('/menu');

        $response->assertStatus(200);
        $response->assertSee('Kelola Menu');
    }

    public function test_owner_can_create_menu(): void
    {
        $this->actingAs($this->owner);

        $response = $this->post('/menu', [
            'nama' => 'Mie Ayam Special',
            'harga' => 20000,
            'stok' => 50,
        ]);

        $response->assertRedirect('/menu');
        $this->assertDatabaseHas('menus', [
            'nama' => 'Mie Ayam Special',
            'harga' => 20000,
            'stok' => 50,
        ]);
    }

    public function test_owner_can_update_menu(): void
    {
        $this->actingAs($this->owner);

        $menu = Menu::factory()->create([
            'nama' => 'Old Menu',
            'harga' => 15000,
            'stok' => 30,
        ]);

        $response = $this->put("/menu/{$menu->id}", [
            'nama' => 'Updated Menu',
            'harga' => 18000,
            'stok' => 40,
        ]);

        $response->assertRedirect('/menu');
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'nama' => 'Updated Menu',
            'harga' => 18000,
            'stok' => 40,
        ]);
    }

    public function test_owner_can_delete_menu(): void
    {
        $this->actingAs($this->owner);

        $menu = Menu::factory()->create();

        $response = $this->delete("/menu/{$menu->id}");

        $response->assertRedirect('/menu');
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_menu_requires_validation(): void
    {
        $this->actingAs($this->owner);

        $response = $this->post('/menu', []);

        $response->assertSessionHasErrors(['nama', 'harga', 'stok']);
    }

    public function test_kasir_cannot_access_menu_management(): void
    {
        $kasir = User::factory()->kasir()->create();

        $this->actingAs($kasir);

        $response = $this->get('/menu');

        $response->assertStatus(403);
    }
}
