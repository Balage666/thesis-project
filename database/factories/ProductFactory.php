<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $userID = User::whereHas('Roles', function($query) {
            $query->where('name', '=', 'Seller');
        })->inRandomOrder()->first()->id;
        $randomCategoryId = Category::inRandomOrder()->first()->id;
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'price' => number_format($this->faker->randomFloat(2, 5, 15), 2),
            'stock' => $this->faker->numberBetween(0, 100),
            'created_by' => $userID,
            'category_id' => $randomCategoryId,
        ];
    }
}
