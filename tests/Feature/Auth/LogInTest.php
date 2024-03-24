<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class LogInTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh --seed');
    }


    /**
     * A basic feature test example.
     */
    public function test_log_in_page_accessible(): void
    {
        $response = $this->get(route('log-in'));
        $response->assertOk();
        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Auth/LogIn');
            $page->url('/auth/log-in');
        });
    }


    public function test_log_in_without_credentials(): void
    {

        $response = $this->get(route('log-in'));

        $response = $this->followingRedirects()->post(route('log-on'))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/LogIn");
            $page->has('errors')
                ->where("errors.email", "The email field is required.")
                ->where("errors.password", "The password field is required.");
        });
    }

    public function test_log_in_with_credentials(): void
    {
        $response = $this->get(route('log-in'));

        $response = $this->followingRedirects()->post(route('log-on', ['email' => 'admin@bluevenue.tp', 'password' => 'admin']))->assertInertia(function (AssertableInertia $page) {
            $page->component("Storefront");
            $page->url('/storefront');
        });
    }

    public function test_log_in_with_non_existing_user(): void
    {
        $response = $this->get(route('log-in'));

        $response = $this->followingRedirects()->post(route('log-on', ['email' => 'test.user@bluevenue.tp', 'password' => 'test']))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/LogIn");
            $page->has('errors')->where("errors.email", "Invalid credentials");
        });
    }
}
