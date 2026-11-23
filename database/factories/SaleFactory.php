<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // نوزّع الحالة عشوائيًا: نشط دلوقتي / قادم / منتهي
        $type = fake()->randomElement(['active', 'upcoming', 'expired']);

        return match ($type) {
            'active' => [
                'percentage' => fake()->randomFloat(2, 5, 70),
                'start_date' => now()->subDays(fake()->numberBetween(1, 10)),
                'end_date'   => now()->addDays(fake()->numberBetween(3, 30)),
                'is_active'  => true,
            ],

            'upcoming' => [
                'percentage' => fake()->randomFloat(2, 5, 70),
                'start_date' => now()->addDays(fake()->numberBetween(1, 15)),
                'end_date'   => now()->addDays(fake()->numberBetween(16, 45)),
                'is_active'  => true,
            ],

            'expired' => [
                'percentage' => fake()->randomFloat(2, 5, 70),
                'start_date' => now()->subDays(fake()->numberBetween(30, 60)),
                'end_date'   => now()->subDays(fake()->numberBetween(1, 29)),
                'is_active'  => true,
            ],
        };
    }

    /**
     * عرض نشط دلوقتي.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(fake()->numberBetween(1, 10)),
            'end_date'   => now()->addDays(fake()->numberBetween(3, 30)),
            'is_active'  => true,
        ]);
    }

    /**
     * عرض لسه ماجاش وقته.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->addDays(fake()->numberBetween(1, 15)),
            'end_date'   => now()->addDays(fake()->numberBetween(16, 45)),
            'is_active'  => true,
        ]);
    }

    /**
     * عرض خلصت مدته.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(fake()->numberBetween(30, 60)),
            'end_date'   => now()->subDays(fake()->numberBetween(1, 29)),
            'is_active'  => true,
        ]);
    }

    /**
     * عرض متوقف يدويًا (is_active = false) بغض النظر عن التواريخ.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
