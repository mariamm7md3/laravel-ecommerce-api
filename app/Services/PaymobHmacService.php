<?php

namespace App\Services;

class PaymobHmacService
{
    private const FIELDS_ORDER = [
        'amount_cents',
        'created_at',
        'currency',
        'error_occured',
        'has_parent_transaction',
        'id',
        'integration_id',
        'is_3d_secure',
        'is_auth',
        'is_capture',
        'is_refunded',
        'is_standalone_payment',
        'is_voided',
        'order.id',
        'owner',
        'pending',
        'source_data.pan',
        'source_data.sub_type',
        'source_data.type',
        'success',
    ];

    public function verify(array $obj, string $receivedHmac): bool
    {
        $calculated = $this->calculate($obj);

        return hash_equals($calculated, $receivedHmac);
    }

    private function calculate(array $obj): string
    {
        $concatenated = '';

        foreach (self::FIELDS_ORDER as $field) {
            $value = $this->getValue($obj, $field);
            $concatenated .= $this->toHmacString($value);
        }

        return hash_hmac('sha512', $concatenated, config('paymob.hmac_secret'));
    }

    private function getValue(array $obj, string $field)
    {
        if (str_contains($field, '.')) {
            [$parent, $child] = explode('.', $field);
            return $obj[$parent][$child] ?? null;
        }

        return $obj[$field] ?? null;
    }

    private function toHmacString($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string) ($value ?? '');
    }
}
