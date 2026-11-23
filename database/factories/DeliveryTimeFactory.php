<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class DeliveryTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id'   => Branch::query()->inRandomOrder()->first()->id,
            'day_of_week' => fake()->randomElement(['saturday','sunday','monday','tuesday','wednesday','thursday','friday']),
            'start_time'  => '09:00:00',
            'end_time'    => '21:00:00',
            'is_active'   => true,
        ];
    }
}
