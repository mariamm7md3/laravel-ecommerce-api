<?php

namespace Database\Factories;

use App\Models\DiscountCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiscountCode>
 */
class DiscountCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'               => strtoupper(fake()->unique()->lexify('????##')),
            'start_date'         => now(),
            'end_date'           => now()->addDays(30),
            'percentage'         => fake()->randomFloat(2, 5, 50),
            'max_discount_limit' => fake()->randomFloat(2, 50, 500),
            'usage_limit'        => fake()->numberBetween(10, 100),
            'is_once'            => false,
            'is_active'          => true,
        ];
    }
}
