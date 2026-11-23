<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function updateStatus(Order $order, OrderStatus $newStatus): Order
    {
        $currentStatus = $order->status;

        if (! $currentStatus->canTransitionTo($newStatus, $order)) {
            throw ValidationException::withMessages([
                'status' => __('orders.invalid_transition', [
                    'from' => $currentStatus->label(),
                    'to'   => $newStatus->label(),
                ]),
            ]);
        }

        $order->update(['status' => $newStatus]);

        return $order->fresh();
    }

}
