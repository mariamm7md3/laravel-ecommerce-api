<?php

namespace Database\Factories;

use App\Models\ProductUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductUnit>
 */
class ProductUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = [
            ['ar' => 'قطعة', 'en' => 'piece'],
            ['ar' => 'كيلو', 'en' => 'kg'],
            ['ar' => 'لتر', 'en' => 'liter'],
            ['ar' => 'صندوق', 'en' => 'box'],
            ['ar' => 'عبوة', 'en' => 'pack'],
        ];
        return [
            'name'      => fake()->randomElement($units),
            'is_active' => true,
        ];
    }
}
