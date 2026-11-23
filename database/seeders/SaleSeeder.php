<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // عروض نشطة
        Sale::factory(5)->active()->create();

// عروض قادمة
        Sale::factory(3)->upcoming()->create();

// عروض منتهية
        Sale::factory(4)->expired()->create();

        // عروض متوقفة يدويًا (بغض النظر عن التاريخ)
        Sale::factory(2)->inactive()->create();

// عروض عشوائية تمامًا (تستخدم الـ definition() الأساسية اللي بتنوّع لوحدها)
        Sale::factory(6)->create();
    }
}
