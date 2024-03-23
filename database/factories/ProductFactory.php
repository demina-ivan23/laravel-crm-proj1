<?php

namespace Database\Factories;

use App\Models\ProductCategory;
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
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 4, 1000),
            'product_image' => null,
            'category_id' => $this->faker->numberBetween(ProductCategory::min('id'), ProductCategory::max('id'))
        ];
    }
}
