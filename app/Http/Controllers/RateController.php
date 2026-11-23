<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request , Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return $this->errorResponse(__('messages.order.not_found'), 404);
        }

        if ($order->status !== OrderStatus::Delivered->value) {
            return $this->errorResponse(__('messages.rate.order_not_delivered'), 422);
        }

        if ($order->rate) {
            return $this->errorResponse(__('messages.rate.already_rated'), 422);
        }

        $data = $request->validate([
            'stars'   => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:500',
        ]);

        $rate = $order->rate()->create($data);

        return $this->successResponse(
            __('messages.rate.created')
        );
    }
}
