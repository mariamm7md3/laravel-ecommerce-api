<?php

namespace Database\Factories;

use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductSize>
 */
class ProductSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sizes = [
            ['ar' => '250 مل', 'en' => '250ml'],
            ['ar' => '500 مل', 'en' => '500ml'],
            ['ar' => '1 لتر', 'en' => '1L'],
            ['ar' => '2 لتر', 'en' => '2L'],
            ['ar' => '250 جرام', 'en' => '250g'],
            ['ar' => '500 جرام', 'en' => '500g'],
            ['ar' => '1 كيلو', 'en' => '1kg'],
        ];

        return [
            'name'      => fake()->randomElement($sizes),
            'is_active' => true,
        ];
    }
}
