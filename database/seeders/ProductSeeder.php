<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $industries = Industry::all();
        foreach ($industries as $industry) {
            Product::factory(12)->create([
                'industry_id' => $industry->id,
            ]);
        }
    }
}
