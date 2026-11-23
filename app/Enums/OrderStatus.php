<?php

namespace App\Enums;

use App\Models\Order;

enum OrderStatus: string
{
    case Requested = 'requested';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case OnDelivery = 'on-delivery';
    case Pending = 'pending';
    case Paid = 'paid';

    public function allowedTransitions(?Order $order = null): array
    {
        $isOnlinePayment = $order?->payment
            && in_array($order->payment->paymentMethod->name, ['online_payment', 'pay_from_link']);

        return match($this){
            self::Pending => $isOnlinePayment
                ? [self::Requested, self::Cancelled, self::Paid]
                : [self::Requested, self::Cancelled],
            self::Requested => [self::OnDelivery, self::Cancelled],
            self::OnDelivery => [self::Delivered, self::Cancelled],
            self::Delivered => [],
            self::Cancelled => [self::Pending],
            self::Paid => [self::Requested, self::Cancelled],
        };
    }

    public function canTransitionTo(self $status, ?Order $order = null): bool
    {
        return in_array($status, $this->allowedTransitions($order), true);
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Pending    => 'warning',
            self::Requested  => 'info',
            self::OnDelivery => 'warning',
            self::Delivered  => 'success',
            self::Cancelled  => 'danger',
            self::Paid       => 'primary',
        };
    }

    public function label(): string
    {
        return __('orders.status.' . $this->value);
    }
}
