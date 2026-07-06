<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_displayed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Mang Bob POS');
    }

    public function test_users_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => 'password',
            'role' => 'kasir',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_owner_redirects_to_dashboard_after_login(): void
    {
        $user = User::factory()->owner()->create([
            'email' => 'owner@gmail.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'owner@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_kasir_redirects_to_transaction_after_login(): void
    {
        $user = User::factory()->kasir()->create([
            'email' => 'kasir@gmail.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'kasir@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/transaction');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_kasir_cannot_access_owner_routes(): void
    {
        $user = User::factory()->kasir()->create();

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_owner_cannot_access_kasir_routes(): void
    {
        $user = User::factory()->owner()->create();

        $this->actingAs($user);

        $response = $this->get('/transaction');

        $response->assertStatus(403);
    }
}
