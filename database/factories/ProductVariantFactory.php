<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductUnit;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price'          => fake()->randomFloat(2, 5, 300),
            'stock_quantity' => fake()->numberBetween(0, 200),
            'product_limit'  => fake()->numberBetween(1, 10),
            'rate'           => fake()->randomFloat(1, 1, 5),
            'unit_id'        => ProductUnit::inRandomOrder()->first()->id,
            'product_id'     => Product::inRandomOrder()->first()->id,
            'product_size_id'=> ProductSize::inRandomOrder()->first()->id,
        ];
    }
}
