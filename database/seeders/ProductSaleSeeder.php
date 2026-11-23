<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = ProductVariant::all();
        $sales    = Sale::all();

        // خلي بس جزء من الـ variants عندهم sale مش كلهم
        $variants->random(10)->each(function ($variant) use ($sales) {
            $variant->sales()->attach(
                $sales->random()->id
            );
        });
    }
}
