<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Industry>
 */
class IndustryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $industries = [
            ['ar' => 'جهينة',        'en' => 'Juhayna'],
            ['ar' => 'دومتي',        'en' => 'Domty'],
            ['ar' => 'فرج الله',     'en' => 'Faragalla'],
            ['ar' => 'قها',          'en' => 'Qaha'],
            ['ar' => 'إيديتا',       'en' => 'Edita'],
            ['ar' => 'المراعي',      'en' => 'Almarai'],
            ['ar' => 'بيبسي',        'en' => 'PepsiCo'],
            ['ar' => 'كوكاكولا',     'en' => 'Coca-Cola'],
            ['ar' => 'يونيليفر',     'en' => 'Unilever'],
            ['ar' => 'نستله',        'en' => 'Nestlé'],
        ];

        return [
            'name' => fake()->unique()->randomElement($industries),
        ];
    }
}
