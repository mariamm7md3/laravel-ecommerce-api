<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymobService
{
    public function handlePayment(Order $order ): Payment
    {
        $payment = $order->payment;
        $methodName = $payment->paymentMethod->name;

        if ($methodName === 'cash') {
            return $payment;
        }

        if ($methodName === 'online_payment') {
            return $this->handleOnlinePayment($order, $payment);
        }

        return $payment;
    }

    private function handleOnlinePayment(Order $order, Payment $payment): Payment
    {
        $response = $this->createIntention($order);
        $clientSecret = $response['client_secret']?? null;

        $checkoutUrl = $clientSecret
            ? config('paymob.base_url') . '/unifiedcheckout/?publicKey=' . config('paymob.public_key') . '&clientSecret=' . $clientSecret
            : null;

        $payment->update([
            'paymob_order_id'  => $response['id'] ?? null,
            'payment_url'      => $checkoutUrl,
            'gateway_response' => $response,
        ]);

        return $payment->fresh();

    }

    private function createIntention(Order $order): array
    {
        $response = Http::withToken(config('paymob.secret_key'), 'Token')
            ->post(config('paymob.base_url') . '/v1/intention/', [
                'amount' => $order->total * 100,
                'currency' => 'EGP',
                'payment_methods' => [(int) config('paymob.integration_id')],
                'items' => [],
                'special_reference' => (string) $order->id,
                'billing_data' => [
                    'first_name' => $order->user->first_name ?? 'NA',
                    'last_name' => $order->user->last_name ?? 'NA',
                    'email' => $order->user->email ?? 'na@na.com',
                    'phone_number' => $order->user->phone ?? 'NA',
                ],
            ]);

        return $response->json();
    }


}
