<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WishList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            WishList::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
