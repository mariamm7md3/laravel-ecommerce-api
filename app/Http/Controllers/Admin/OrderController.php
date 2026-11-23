<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\NotificationService;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(
        protected OrderStatusService $orderStatusService ,
        NotificationService $notificationService
    ) {
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page= $request->input('per_page', 10);

        $orders = Order::query()
            ->with(['user' , 'branch' , 'deliveryTime' , 'payment'])
            ->adminFilter($request)
            ->withCount(['items'])
            ->latest('date')
            ->latest('id')
            ->paginate($per_page );

        $statuses = OrderStatus::cases();

        return view('orders.index', compact('orders' , 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::withTrashed()->findOrFail($id);

        $order->load([
            'user',
            'branch',
            'address',
            'deliveryTime',
            'items.variant.product',
            'items.variant.productUnit',
            'items.variant.productSize',
            'discountCodes',
            'rate',
            'payment.paymentMethod'
        ]);

        return view('orders.show', compact('order'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    Public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_column(OrderStatus::cases(), 'value')),
        ]);

        $newStatus = OrderStatus::from($request->status);

        $this->orderStatusService->updateStatus($order, $newStatus);

        $this->notificationService->send(
            user: $order->user,
            title: 'تحديث حالة الطلب',
            message: "تم تحديث حالة طلبك رقم #{$order->id} إلى: {$newStatus->label()}",
            order: $order,
            type: 'order_status_changed'
        );

        return response()->json([
            'success'        => true,
            'dropdown_html'  => view('orders.partials.status-dropdown', ['order' => $order->fresh()])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', __('orders.order_deleted'));
    }

}
