<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PushNotificationService
{
    public function sendNotification($user, $notification)
    {
        if (!$user->push_subscription) {
            return;
        }

        $subscription = json_decode($user->push_subscription, true);

        $payload = [
            'title' => $notification->title,
            'body' => $notification->body,
            'icon' => '/icons/icon-192x192.png',
            'badge' => '/icons/icon-72x72.png',
            'url' => $notification->action_url ?? '/',
            'data' => [
                'id' => $notification->id,
                'type' => get_class($notification)
            ]
        ];

        $this->sendPushNotification($subscription, json_encode($payload));
    }

    private function sendPushNotification($subscription, $payload)
    {
        $vapidHeaders = $this->getVapidHeaders($subscription['endpoint']);

        try {
            Http::withHeaders($vapidHeaders)
                ->post($subscription['endpoint'], $payload);
        } catch (\Exception $e) {
            \Log::error('Push notification failed: ' . $e->getMessage());
        }
    }

    private function getVapidHeaders($endpoint)
    {
        // In a real application, you would generate these using your VAPID keys
        // For now, we'll return placeholder headers
        return [
            'Authorization' => 'Bearer ' . config('services.webpush.public_key'),
            'Content-Type' => 'application/json',
            'TTL' => 86400
        ];
    }
}
