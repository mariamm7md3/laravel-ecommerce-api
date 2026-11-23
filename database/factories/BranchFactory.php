<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            ['ar' => 'المعادي', 'en' => 'Maadi'],
            ['ar' => 'مدينة نصر', 'en' => 'Nasr City'],
            ['ar' => 'الزمالك', 'en' => 'Zamalek'],
            ['ar' => 'المهندسين', 'en' => 'Mohandessin'],
            ['ar' => 'الإسكندرية', 'en' => 'Alexandria'],
        ];

        $city = fake()->unique()->randomElement($cities);

        return [
            'name' => [
                'ar' => 'فرع ' . $city['ar'],
                'en' => $city['en'] . ' Branch',
            ],
            'address' => [
                'ar' => 'شارع رئيسي، ' . $city['ar'],
                'en' => 'Main Street, ' . $city['en'],
            ],
            'shipping_cost' => fake()->randomFloat(2, 3, 10),
        ];
    }
}
