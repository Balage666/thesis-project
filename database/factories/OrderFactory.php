<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'status' => 'paid',
            'full_name' => $user->name,
            'email' => $user->email,
            'address_text' => fake('en_US')->address(),
            'state_or_region' => fake()->stateAbbr(),
            'postal_or_zip_code' => fake('en_US')->postcode(),
            'country' => fake('en_US')->countryCode(),
            'phone_number' => fake()->randomNumber(9, true),
        ];
    }
}
