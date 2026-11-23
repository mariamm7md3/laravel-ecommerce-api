<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\AddressFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndustrySeeder::class,
            CategorySeeder::class,
            BranchSeeder::class,
            DeliveryTimeSeeder::class,
            ProductSizeSeeder::class,
            ProductUnitSeeder::class,
            SaleSeeder::class,
            DiscountCodeSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            ProductCategorySeeder::class,
            ProductSaleSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,      // ← الـ addresses الأول
            OrderSeeder::class,        // ← بعدين الـ orders
            OrderItemSeeder::class,
            CartSeeder::class,
            CartItemsSeeder::class,
            WishlistSeeder::class,
            WishlistItemSeeder::class,
        ]);
    }
}
