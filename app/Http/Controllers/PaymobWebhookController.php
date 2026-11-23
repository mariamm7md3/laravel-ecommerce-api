<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Services\PaymobHmacService;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymobWebhookController extends Controller
{
    public function __construct(
        private PaymobHmacService $hmacService
    ) {}

    public function handle(Request $request)
    {
        $receivedHmac = $request->query('hmac');

        if (!$receivedHmac) {
            Log::warning('Paymob webhook: hmac مفقود من الـ request');
            return response()->json(['message' => 'hmac missing'], 400);
        }

        // 2) هات الـ obj من الـ body
        $payload = $request->all();
        $obj = $payload['obj'] ?? null;

        if (!$obj) {
            Log::warning('Paymob webhook: obj مفقود من الـ payload');
            return response()->json(['message' => 'invalid payload'], 400);
        }

        // 3) التحقق من الـ HMAC — دي البوابة، ماينفعش نعدّيها
        if (!$this->hmacService->verify($obj, $receivedHmac)) {
            Log::warning('Paymob webhook: HMAC غير متطابق', [
                'received_hmac' => $receivedHmac,
                'order_ref' => $obj['order']['merchant_order_id'] ?? null,
            ]);
            return response()->json(['message' => 'invalid signature'], 401);
        }

        // 4) لو وصلنا هنا يبقى الداتا موثوقة 100% — نكمل نستخرج ونحدّث
        $merchantOrderId = $obj['order']['merchant_order_id'] ?? null;
        $paymobOrderId   = $obj['order']['id'] ?? null;
        $transactionId   = $obj['id'] ?? null;
        $success         = $obj['success'] ?? false;
        $amountCents     = $obj['amount_cents'] ?? 0;

        if (!$merchantOrderId) {
            Log::warning('Paymob webhook: merchant_order_id مفقود');
            return response()->json(['message' => 'order reference missing'], 400);
        }

        $order = Order::find($merchantOrderId);

        if (!$order) {
            Log::warning("Paymob webhook: مفيش أوردر بالرقم {$merchantOrderId}");
            return response()->json(['message' => 'order not found'], 404);
        }

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'paymob_order_id'   => $paymobOrderId,
                'transaction_id'    => $transactionId,
                'amount'            => $amountCents / 100, // من قروش لجنيه
                'status'            => $success ? PaymentStatus::Success->value : PaymentStatus::Failed->value,
                'paid_at'           => $success ? now() : null,
                'gateway_response'  => json_encode($obj),
            ]
        );

        // 2) نحدّث حالة الأوردر نفسه لو الدفع نجح
        if ($success) {
            $order->update([
                'status' => OrderStatus::Paid->value,
            ]);
        }

        Log::info("Paymob webhook: الأوردر {$merchantOrderId} اتحدّث بنجاح", [
            'transaction_id' => $transactionId,
            'payment_status' => $success ? 'success' : 'failed',
        ]);

        return response()->json(['message' => 'ok'], 200);
    }

}
