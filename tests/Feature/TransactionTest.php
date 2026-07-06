<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected User $kasir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kasir = User::factory()->kasir()->create([
            'password' => 'password',
        ]);
    }

    public function test_kasir_can_view_pos_screen(): void
    {
        $this->actingAs($this->kasir);

        $response = $this->get('/transaction');

        $response->assertStatus(200);
        $response->assertSee('Transaksi Baru');
    }

    public function test_kasir_can_create_transaction(): void
    {
        $this->actingAs($this->kasir);

        $menu = Menu::factory()->create([
            'harga' => 15000,
            'stok' => 50,
        ]);

        $response = $this->post('/transaction', [
            'items' => [
                ['menu_id' => $menu->id, 'jumlah' => 2],
            ],
            'bayar' => 50000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->kasir->id,
            'total' => 30000,
            'bayar' => 50000,
            'kembalian' => 20000,
        ]);

        $menu->refresh();
        $this->assertEquals(48, $menu->stok);
    }

    public function test_kasir_can_view_receipt(): void
    {
        $this->actingAs($this->kasir);

        $transaction = Transaction::factory()->create([
            'user_id' => $this->kasir->id,
        ]);

        $response = $this->get("/transaction/{$transaction->id}/receipt");

        $response->assertStatus(200);
        $response->assertSee('Struk');
    }

    public function test_kasir_can_view_history(): void
    {
        $this->actingAs($this->kasir);

        $response = $this->get('/history');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Transaksi');
    }

    public function test_kasir_can_view_transaction_detail(): void
    {
        $this->actingAs($this->kasir);

        $transaction = Transaction::factory()->create([
            'user_id' => $this->kasir->id,
        ]);

        $response = $this->get("/history/{$transaction->id}");

        $response->assertStatus(200);
        $response->assertSee('Detail Transaksi');
    }

    public function test_owner_cannot_create_transaction(): void
    {
        $owner = User::factory()->owner()->create();

        $this->actingAs($owner);

        $response = $this->get('/transaction');

        $response->assertStatus(403);
    }

    public function test_transaction_requires_items(): void
    {
        $this->actingAs($this->kasir);

        $response = $this->post('/transaction', [
            'items' => [],
            'bayar' => 50000,
        ]);

        $response->assertSessionHasErrors(['items']);
    }

    public function test_insufficient_payment_creates_negative_change(): void
    {
        $this->actingAs($this->kasir);

        $menu = Menu::factory()->create([
            'harga' => 50000,
            'stok' => 10,
        ]);

        $response = $this->post('/transaction', [
            'items' => [
                ['menu_id' => $menu->id, 'jumlah' => 2],
            ],
            'bayar' => 50000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'total' => 100000,
            'bayar' => 50000,
            'kembalian' => -50000,
        ]);
    }
}
