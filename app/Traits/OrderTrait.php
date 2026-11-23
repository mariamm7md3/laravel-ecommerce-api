<?php

namespace App\Traits;

use App\Enums\PaymentStatus;
use App\Models\{Order, OrderItem, OrderDiscount, Payment, UserDiscountUsage, DiscountCode, DeliveryTime, User};
use App\Events\OrderCreated;
use Illuminate\Support\Facades\DB;

trait OrderTrait
{
    public function createOrder(User $user, array $data): Order
    {
        $address = $this->validateAddress($user, $data['address_id']);
        $deliveryTime = DeliveryTime::with('branch')->findOrFail($data['delivery_time_id']);
        $branch = $deliveryTime->branch;

        $cart = $this->validateCart($user);
        $subTotal = $this->calculateSubTotal($cart);
        $shipping = $branch->shipping_cost;

        [$discountCode, $discountAmount] = $this->applyDiscount(
            $data['discount_code'] ?? null,
            $user,
            $subTotal
        );

        $total = round($subTotal + $shipping - $discountAmount, 2);

        return DB::transaction(function () use (
            $user, $branch, $address, $deliveryTime, $cart,
            $subTotal, $shipping, $discountAmount, $total,
            $discountCode, $data
        ) {
            $order = Order::create([
                'user_id'          => $user->id,
                'branch_id'        => $branch->id,
                'address_id'       => $address->id,
                'delivery_time_id' => $deliveryTime->id,
                'sub_total'        => $subTotal,
                'shipping'         => $shipping,
                'discount'         => $discountAmount,
                'total'            => $total,
                'additional_info'  => $data['additional_info'] ?? null,
            ]);

            $this->createOrderItems($order, $cart);
            $this->finalizeDiscount($order, $discountCode, $user);

            $payment = $this->createPayment($order, $data);
            $order->setRelation('payment', $payment);

            $cart->items()->delete();
            $cart->delete();

            event(new OrderCreated($order));

            return $order;
        });
    }

    private function validateAddress(User $user, int $addressId)
    {
        $address = $user->addresses()->find($addressId);
        abort_if(!$address, 422, __('messages.order.invalid_address'));
        return $address;
    }

    private function validateCart(User $user)
    {
        $cart = $user->cart()->with(['items.variant.sales' => fn($q) =>
        $q->active()->where('end_date', '>=', now())
        ])->first();

        abort_if(!$cart || $cart->items->isEmpty(), 422, __('messages.order.invalid_cart'));

        foreach ($cart->items as $item) {
            abort_if(
                $item->quantity > $item->variant->stock_quantity,
                422,
                __('messages.cart.out_of_stock')
            );
        }

        return $cart;
    }

    private function calculateSubTotal($cart): float
    {
        return $cart->items->sum(function ($item) {
            $variant    = $item->variant;
            $activeSale = $variant->sales->first();
            $price      = $activeSale
                ? round($variant->price - ($variant->price * ($activeSale->percentage / 100)), 2)
                : $variant->price;
            return round($price * $item->quantity, 2);
        });
    }

    private function applyDiscount(?string $code, User $user, float $subTotal): array
    {
        if (!$code) {
            return [null, 0];
        }

        $discountCode = DiscountCode::where('code', $code)
            ->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        abort_if(!$discountCode, 422, __('messages.discount_code.invalid'));

        $totalUsage = OrderDiscount::where('discount_code_id', $discountCode->id)->count();
        abort_if($totalUsage >= $discountCode->usage_limit, 422, __('messages.discount_code.usage_limit'));

        if ($discountCode->is_once) {
            $alreadyUsed = UserDiscountUsage::where('user_id', $user->id)
                ->where('discount_code_id', $discountCode->id)
                ->exists();
            abort_if($alreadyUsed, 422, __('messages.discount_code.already_used'));
        }

        $amount = round($subTotal * ($discountCode->percentage / 100), 2);
        $amount = min($amount, $discountCode->max_discount_limit);

        return [$discountCode, $amount];
    }

    private function createOrderItems(Order $order, $cart): void
    {
        foreach ($cart->items as $item) {
            $variant    = $item->variant;
            $activeSale = $variant->sales->first();
            $price      = $activeSale
                ? round($variant->price - ($variant->price * ($activeSale->percentage / 100)), 2)
                : $variant->price;

            OrderItem::create([
                'order_id'           => $order->id,
                'product_variant_id' => $variant->id,
                'quantity'           => $item->quantity,
                'price'              => $price,
            ]);

            $variant->decrement('stock_quantity', $item->quantity);
        }
    }

    private function finalizeDiscount(Order $order, ?DiscountCode $discountCode, User $user): void
    {
        if (!$discountCode) {
            return;
        }

        OrderDiscount::create([
            'order_id'         => $order->id,
            'discount_code_id' => $discountCode->id,
        ]);

        if ($discountCode->is_once) {
            UserDiscountUsage::create([
                'user_id'          => $user->id,
                'discount_code_id' => $discountCode->id,
            ]);
        }
    }

    private function createPayment(Order $order , array $data) : Payment
    {
        return Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => (int)$data['payment_method_id'],
            'amount' => $order->total ,
            'status' => PaymentStatus::Pending->value,
            'transaction_id'    => null,
            'payment_url'       => null,
            'paid_at'           => null,
            'gateway_response'  => null,
            'paymob_order_id'   => null,
        ]);
    }
}
