<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $Username = fake()->firstName()." ".fake()->lastName();
        $UsernameParts = explode(" ", $Username);
        $Domains = ["@gmail.com", "@protonmail.com", "@ncob.com", "@simgatsy.com", "@simgatla.com", "@flipbasket.tp"];
        return [
            'name' => $Username,
            'email' => strtolower($UsernameParts[0]).".".strtolower($UsernameParts[1]).fake()->randomElement($Domains),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name={$UsernameParts[0]}+{$UsernameParts[1]}",
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
