<?php

namespace App\Events;

use App\Models\UserMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserMessage $userMessage;
    /**
     * Create a new event instance.
     */
    public function __construct(UserMessage $userMessage)
    {
        $this->userMessage = $userMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-message-sent'),
        ];
    }
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
    public function broadcastWith(): array
    {
        return [
            'title'=>$this->userMessage->title,
            'body'=>$this->userMessage->body,
            'sender_name'=>$this->userMessage->user->first_name ?? __('notifications.unknown_sender'),
        ];
    }
}
