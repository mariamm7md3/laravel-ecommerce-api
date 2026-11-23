<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Branch;
use App\Models\DeliveryTime;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = fake()->randomFloat(2, 50, 1000);
        $discount = fake()->randomFloat(2, 0, 50);
        $shipping = fake()->randomFloat(2, 10, 50);
        return [
            'user_id'          => User::query()->inRandomOrder()->first()->id,
            'branch_id'        => Branch::query()->inRandomOrder()->first()->id,
            'address_id'       => Address::query()->inRandomOrder()->first()->id,
            'delivery_time_id' => DeliveryTime::query()->inRandomOrder()->first()->id,
            'sub_total'        => $subTotal,
            'total'            => $subTotal - $discount + $shipping,
            'discount'         => $discount,
            'shipping'         => $shipping,
            'additional_info'  => null,
            'delivered_by'     => null,
            'status'           => 'pending',
            'date'             => now(),
        ];
    }
}
