<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WishList;
use App\Models\WishListItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wishlists = WishList::all();

        foreach ($wishlists as $wishlist) {
            WishlistItem::factory(rand(1, 5))->create([
                'wishlist_id' => $wishlist->id,
            ]);
        }

    }
}
