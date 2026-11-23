<?php

namespace Database\Factories;

use App\Models\Industry;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            ['ar' => 'تفاح أحمر',      'en' => 'Red Apple'],
            ['ar' => 'موز',            'en' => 'Banana'],
            ['ar' => 'برتقال',         'en' => 'Orange'],
            ['ar' => 'مانجو',          'en' => 'Mango'],
            ['ar' => 'عنب',            'en' => 'Grapes'],
            ['ar' => 'فراولة',         'en' => 'Strawberry'],
            ['ar' => 'بطيخ',           'en' => 'Watermelon'],
            ['ar' => 'أناناس',         'en' => 'Pineapple'],
            ['ar' => 'كمثرى',          'en' => 'Pear'],
            ['ar' => 'خوخ',            'en' => 'Peach'],
            ['ar' => 'طماطم',          'en' => 'Tomato'],
            ['ar' => 'خيار',           'en' => 'Cucumber'],
            ['ar' => 'بطاطس',          'en' => 'Potato'],
            ['ar' => 'جزر',            'en' => 'Carrot'],
            ['ar' => 'فلفل ألوان',     'en' => 'Bell Pepper'],
            ['ar' => 'بصل',            'en' => 'Onion'],
            ['ar' => 'ثوم',            'en' => 'Garlic'],
            ['ar' => 'كوسة',           'en' => 'Zucchini'],
            ['ar' => 'باذنجان',        'en' => 'Eggplant'],
            ['ar' => 'خس',             'en' => 'Lettuce'],
        ];
        $product = fake()->randomElement($products);
        return [
            'name'        => $product,
            'photo'       => null,
            'description' => [
                'ar' => $product['ar'] . ' طازج وعالي الجودة، مباشرة من المزرعة',
                'en' => 'Fresh, high-quality ' . $product['en'] . ', straight from the farm',
            ],
            'price'       => fake()->randomFloat(2, 10, 500),
            'rate'        => fake()->randomFloat(1, 1, 5),
            'industry_id' => Industry::inRandomOrder()->first()->id,
            'is_active'   => true,
        ];
    }
}
