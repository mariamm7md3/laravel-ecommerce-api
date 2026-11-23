<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use App\Services\PaymobService;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    use ApiResponseTrait , OrderTrait;

    public function __construct(
        private PaymobService $paymobService
    ) {}
    public function store(Request $request){
        // validate data
        $data = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'delivery_time_id' => 'required|exists:delivery_times,id',
            'discount_code'=>'nullable|string',
            'additional_info'=>'nullable|string',
            'payment_method_id'=>'required|exists:payment_methods,id',
        ]);

        $order = $this->createOrder($request->user(), $data);

        $payment = $this->paymobService->handlePayment($order);
        $order->setRelation('payment', $payment);

        return $this->successResponse(
            __('messages.order.created'),
            new OrderResource($order->load(['items.variant', 'branch', 'address', 'deliveryTime'])),
            201
        );
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return $this->paginatedResponse(
            __('messages.order.index'),
            OrderResource::collection($orders),
        );
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return $this->errorResponse(__('messages.order.not_found'), 404);
        }

        $order->load([
            'items.variant.product',
            'items.variant.productunit',
            'items.variant.productUnit',
            'branch',
            'address',
            'deliveryTime',
            'discountCodes',
        ]);

        return $this->successResponse(
            __('messages.order.show'),
            new OrderResource($order)
        );
    }
}
