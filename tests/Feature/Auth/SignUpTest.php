<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignUpTest extends TestCase
{

    use RefreshDatabase;

    public function test_sign_up_page_accessible(): void
    {
        $response = $this->get(route('sign-up'));
        $response->assertOk();
        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Auth/ImprovedSignUp');
            $page->url('/auth/sign-up');
        });
    }

    public function test_sign_up_without_data_returns_errors_on_every_mandatory_field(): void {
        $response = $this->get(route('sign-up'));

        $response = $this->followingRedirects()->post(route('sign-on'))->assertInertia(function (AssertableInertia $page) {
            $page->component('Auth/ImprovedSignUp');
            $page->has('errors')
                ->where("errors.email", "The email field is required.")
                ->where("errors.name", "The name field is required.")
                ->where("errors.role", "The role field is required.")
                ->where("errors.password", "The password field is required.");
        });
    }

    public function test_sign_up_page_with_missing_name_field(): void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'email' => 'test.user@testing.com',
            'role' => 1,
            'password' => 'Qwerty0123!',
            'password_confirmation' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.name", "The name field is required.");
        });

    }

    public function test_sign_up_page_with_missing_email_field(): void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Test User',
            'role' => 1,
            'password' => 'Qwerty0123!',
            'password_confirmation' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.email", "The email field is required.");
        });

    }

    public function test_sign_up_page_without_selecting_role(): void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Test User',
            'email' => 'test.user@testing.com',
            'password' => 'Qwerty0123!',
            'password_confirmation' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.role", "The role field is required.");
        });

    }

    public function test_sign_up_page_with_missing_password_field(): void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Test User',
            'email' => 'test.user@testing.com',
            'role' => 1,
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.password", "The password field is required.");
        });

    }

    public function test_sign_up_page_without_confirming_password(): void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Test User',
            'email' => 'test.user@testing.com',
            'role' => 1,
            'password' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.password", "The password field confirmation does not match.");
        });

    }

    public function test_sign_up_with_every_credentials() : void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Test User',
            'email' => 'test.user@testing.com',
            'role' => 1,
            'password' => 'Qwerty0123!',
            'password_confirmation' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/LogIn");
            $page->has('flash')->where("flash.message", "Successfully registered!");
        });

    }

    public function test_sign_up_with_every_credentials2() : void {

        $response = $this->get(route('sign-up'));

        $newUser = [
            'name' => 'Seller User',
            'email' => 'seller.user@testing.com',
            'role' => 2,
            'password' => 'Qwerty0123!',
            'password_confirmation' => 'Qwerty0123!',
        ];

        $response = $this->followingRedirects()->post(route('sign-on', $newUser))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/LogIn");
            $page->has('flash')->where("flash.message", "Successfully registered!");
        });

    }

    public function test_sign_up_with_already_existing_user_email() : void {

        $user = User::create([
            'name' => 'Already Exist',
            'email' => 'already.exist@test.com',
            'password' => Hash::make('testing'),
        ]);

        $response = $this->get(route('sign-up'));

        $response = $this->followingRedirects()->post(route('sign-on', [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 1,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]))->assertInertia(function (AssertableInertia $page) {
            $page->component("Auth/ImprovedSignUp");
            $page->has('errors')->where("errors.email", "The email has already been taken.");
        });
    }
}
