<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending  = 'pending';
    case Success  = 'success';
    case Failed   = 'failed';
    case Refunded = 'refunded';

    public function badgeColor(): string
    {
        return match ($this) {
            self::Pending  => 'warning',
            self::Success  => 'success',
            self::Failed   => 'danger',
            self::Refunded => 'secondary',
        };
    }

    public function label(): string
    {
        return __('payments.status.' . $this->value);
    }
}
