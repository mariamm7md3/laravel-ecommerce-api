<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'           => Order::query()->inRandomOrder()->first()->id,
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->first()->id,
            'quantity'           => fake()->numberBetween(1, 10),
            'price'              => fake()->randomFloat(2, 5, 300),
        ];
    }
}
