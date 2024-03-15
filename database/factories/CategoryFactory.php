<?php

namespace Database\Factories;

use App\Models\User;
use App\Http\Helpers\Shared\SeederHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userID = User::inRandomOrder()->first()->id;
        // $categoryType = $this->faker->randomElement(SeederHelper::BASE_CATEGORIES);
        return [
            'name' => ucfirst(fake()->unique()->word()),
            'user_id' => $userID
        ];
    }
}
