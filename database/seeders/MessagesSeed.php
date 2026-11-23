<?php

namespace Database\Seeders;

use App\Models\UserMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessagesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserMessage::factory()->count(10)->create();
        UserMessage::factory()->count(5)->unread()->create();
        UserMessage::factory()->count(3)->replied()->create();
    }
}
