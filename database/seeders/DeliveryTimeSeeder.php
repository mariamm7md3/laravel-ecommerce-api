<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\DeliveryTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            DeliveryTime::factory(3)->create([
                'branch_id' => $branch->id,
            ]);
        }
    }
}
