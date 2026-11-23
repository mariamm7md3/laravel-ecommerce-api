<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = fake()->randomFloat(2, 50, 1000);
        $total = fake()->randomFloat(2, 0, 50);
        return [
            'user_id'   => User::query()->inRandomOrder()->first()->id,
            'sub_total' => $subTotal,
            'total'     => $total,
            'is_active' => true,
        ];
    }
}
