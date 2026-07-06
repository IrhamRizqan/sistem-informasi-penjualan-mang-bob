<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
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

    public function test_owner_can_view_reports(): void
    {
        $this->actingAs($this->owner);

        $response = $this->get('/report');

        $response->assertStatus(200);
        $response->assertSee('Laporan Harian');
    }

    public function test_owner_can_generate_report(): void
    {
        $this->actingAs($this->owner);

        $kasir = User::factory()->kasir()->create();

        Transaction::factory()->count(3)->create([
            'user_id' => $kasir->id,
            'tanggal' => now()->subDay()->toDateString(),
            'total' => 30000,
        ]);

        $response = $this->post('/report/generate', [
            'tanggal' => now()->subDay()->toDateString(),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reports', [
            'total_transaksi' => 3,
            'total_pendapatan' => 90000,
            'generated_by' => $this->owner->id,
        ]);
    }

    public function test_owner_can_view_report_detail(): void
    {
        $this->actingAs($this->owner);

        $report = Report::factory()->create([
            'generated_by' => $this->owner->id,
        ]);

        $response = $this->get("/report/{$report->id}");

        $response->assertStatus(200);
        $response->assertSee('Detail Laporan');
    }

    public function test_owner_can_export_pdf(): void
    {
        $this->actingAs($this->owner);

        $report = Report::factory()->create([
            'generated_by' => $this->owner->id,
        ]);

        $response = $this->get("/report/{$report->id}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_kasir_cannot_access_reports(): void
    {
        $kasir = User::factory()->kasir()->create();

        $this->actingAs($kasir);

        $response = $this->get('/report');

        $response->assertStatus(403);
    }

    public function test_report_requires_valid_date(): void
    {
        $this->actingAs($this->owner);

        $response = $this->post('/report/generate', [
            'tanggal' => '',
        ]);

        $response->assertSessionHasErrors(['tanggal']);
    }
}
