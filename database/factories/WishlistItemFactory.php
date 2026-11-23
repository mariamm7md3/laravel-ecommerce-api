<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\WishList;
use App\Models\WishListItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WishListItem>
 */
class WishlistItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wishlist_id' => WishList::query()->inRandomOrder()->first()->id,
            'product_id'  => Product::query()->inRandomOrder()->first()->id,
        ];
    }
}
