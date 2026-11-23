<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('addresses')->get();

        foreach ($users as $user) {

            if ($user->addresses->isEmpty()) continue;

            Order::factory(12)->create([
                'user_id'    => $user->id,
                'address_id' => $user->addresses->random()->id,
            ]);
        }
    }
}
