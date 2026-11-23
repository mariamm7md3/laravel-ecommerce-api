<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['ar' => 'فواكه',        'en' => 'Fruits'],
            ['ar' => 'خضروات',       'en' => 'Vegetables'],
            ['ar' => 'ألبان وأجبان', 'en' => 'Dairy & Cheese'],
            ['ar' => 'مخبوزات',      'en' => 'Bakery'],
            ['ar' => 'مشروبات',      'en' => 'Beverages'],
            ['ar' => 'لحوم ودواجن',  'en' => 'Meat & Poultry'],
            ['ar' => 'أسماك',        'en' => 'Seafood'],
            ['ar' => 'منظفات',       'en' => 'Cleaning Supplies'],
            ['ar' => 'مجمدات',       'en' => 'Frozen Foods'],
            ['ar' => 'بقالة',        'en' => 'Groceries'],
        ];
        $category = fake()->unique()->randomElement($categories);
        return [
            'name'        => $category,
            'icon'        => null,
            'description' => [
            'ar' => 'كل ما تحتاجه من ' . $category['ar'],
            'en' => 'Everything you need from ' . $category['en'],
            ],
            'is_active'   => true,
        ];
    }
}
