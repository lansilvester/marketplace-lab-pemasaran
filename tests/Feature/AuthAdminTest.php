<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com', 'utype' => 'ADM']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200);
    }

    public function test_non_admin_user_is_redirected_from_admin_routes(): void
    {
        $user = User::factory()->create(['email' => 'user@test.com', 'utype' => 'USR']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_from_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_middleware_allows_all_staff_types(): void
    {
        foreach (['ADM', 'PNJ', 'OPT', 'PBN'] as $utype) {
            $user = User::factory()->create([
                'email' => "{$utype}@test.com",
                'utype' => $utype,
            ]);

            Auth::login($user);

            $request = Request::create('/admin/dashboard');
            $request->setUserResolver(fn () => $user);

            $response = (new AuthAdmin)->handle($request, fn () => new Response('next'));

            $this->assertSame('next', $response->getContent(), "Expected {$utype} to pass through the middleware");

            Auth::logout();
        }
    }

    public function test_middleware_redirects_and_flushes_session_for_non_staff(): void
    {
        $user = User::factory()->create(['email' => 'regular@test.com', 'utype' => 'USR']);

        Auth::login($user);
        session(['foo' => 'bar']);

        $request = Request::create('/admin/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = (new AuthAdmin)->handle($request, fn () => new Response('next'));

        $this->assertSame(route('login'), $response->getTargetUrl());
        $this->assertEmpty(session()->all());
    }
}
