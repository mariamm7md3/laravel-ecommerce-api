<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Contract\Messaging;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function send(
        User $user,
        string $title,
        string $message,
        ?Order $order = null,
        ?string $type = null
    ): void {
        // 1) التخزين في الداتابيز أولًا (ده الأهم، لازم يحصل دايمًا)
        Notification::create([
            'user_id'    => $user->id,
            'order_id'   => $order?->id,
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
        ]);

        // 2) جلب كل توكنات اليوزر (ممكن يكون عنده أكتر من جهاز)
        $tokens = $user->fcmTokens;

        if ($tokens->isEmpty()) {
            return; // مفيش أجهزة مسجلة، بس النوتيفيكيشن اتخزنت في الداتابيز على الأقل
        }

        // 3) اللوب على كل توكن وإرسال الـ push
        foreach ($tokens as $tokenModel) {
            $this->sendToToken($tokenModel->token, $title, $message);
        }
    }

    protected function sendToToken(string $token, string $title, string $body): void
    {
        $cloudMessage = CloudMessage::new()
            ->withToken($token)
            ->withNotification(FirebaseNotification::create($title, $body));

        try {
            $this->messaging->send($cloudMessage);
        } catch (NotFound $e) {
            // التوكن ده باظ/منتهي -> نمسحه من الجدول عشان الجدول يفضل نضيف
            \App\Models\UserFcmToken::where('token', $token)->delete();

            Log::info("FCM token removed (NotFound): {$token}");
        } catch (\Throwable $e) {
            // أي خطأ تاني (مشكلة نت، مشكلة في الـ credentials..) بنسجله بس مش بنمسح التوكن
            Log::error("FCM send failed for token {$token}: " . $e->getMessage());
        }
    }
}
