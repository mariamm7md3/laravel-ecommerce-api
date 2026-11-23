<?php

namespace Database\Factories;

use App\Enums\MessageStatus;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserMessage>
 */
class UserMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'title' => fake()->sentence(4),
            'body' => fake()->paragraph(3),
            'status' => fake()->randomElement(MessageStatus::cases())->value,
        ];
    }

    /**
     * State: message is unread
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MessageStatus::Unread->value,
        ]);
    }

    /**
     * State: message has been replied to
     */
    public function replied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MessageStatus::Replied->value,
        ]);
    }
}
