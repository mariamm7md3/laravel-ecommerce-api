<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::query()->inRandomOrder()->first()->id,
            'nickname'     => fake()->randomElement(['البيت', 'الشغل', 'أهل']),
            'phone'        => fake()->phoneNumber(),
            'governate'    => fake()->city(),
            'type'         => fake()->randomElement(['home', 'work', 'other']),
            'building'     => fake()->buildingNumber(),
            'floor'        => fake()->numberBetween(0, 20),
            'apartment'    => fake()->numberBetween(1, 50),
            'details'      => fake()->sentence(),
            'neighborhood' => fake()->word(),
            'is_active'    => true,
            'is_main'      => false,
        ];
    }
}
