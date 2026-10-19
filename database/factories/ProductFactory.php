<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        return [
            'category_id' => Category::factory(),
            'code'        => fake()->unique()->bothify('PRD-####'),
            'name'        => fake()->words(3, true),
            'unit'        => fake()->randomElement(['pcs', 'kg', 'liter', 'box']),
            'price'       => fake()->numberBetween(1000, 500000),
            'stock'       => fake()->numberBetween(0, 100),
        ];
    }
}
