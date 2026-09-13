<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_login_page(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_admin_can_authenticate_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@bapperida.pringsewukab.go.id',
            'password' => 'PasswordBapperida2026!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));

        // Verify audit log recorded
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'auth.login',
        ]);

        // Verify last_login_at updated
        $user = User::where('email', 'admin@bapperida.pringsewukab.go.id')->first();
        $this->assertNotNull($user->last_login_at);
        $this->assertNotNull($user->last_login_ip);
    }

    public function test_admin_cannot_authenticate_with_invalid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@bapperida.pringsewukab.go.id',
            'password' => 'WrongPassword!',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');

        // Verify failure logged
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'auth.failed',
        ]);
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $user = User::where('email', 'admin@bapperida.pringsewukab.go.id')->first();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_admin_can_logout_and_session_is_terminated(): void
    {
        $user = User::where('email', 'admin@bapperida.pringsewukab.go.id')->first();

        $response = $this->actingAs($user)->post(route('admin.logout'));

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'auth.logout',
            'user_id' => $user->id,
        ]);
    }
}
