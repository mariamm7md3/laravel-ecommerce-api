<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Model;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id'            => Cart::query()->inRandomOrder()->first()->id,
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->first()->id,
            'quantity'           => fake()->numberBetween(1, 10),
            'preparation_note'   => null,
        ];
    }
}
