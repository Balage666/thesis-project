<?php

namespace Database\Factories;

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
        $categoryType = $this->faker->randomElement(SeederHelper::BASE_CATEGORIES);
        return [
            'name' => $categoryType,
        ];
    }
}
