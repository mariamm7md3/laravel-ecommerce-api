<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); // جيب الـ users الموجودين بالفعل

        foreach ($users as $user) {
            Address::factory(5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
