<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-orders'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.created';
    }
    public function broadcastWith(): array
    {
        return [
            'order_id'      => $this->order->id,
            'customer_name' => $this->order->user->first_name . ' ' . $this->order->user->last_name,
            'total'         => $this->order->total,
            'branch_name'   => $this->order->branch->name['ar'] ?? '',
        ];
    }
}
