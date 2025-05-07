<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\PushNotificationService;

class WebPushChannel
{
    protected $pushService;

    public function __construct(PushNotificationService $pushService)
    {
        $this->pushService = $pushService;
    }

    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toPush')) {
            $this->pushService->sendNotification(
                $notifiable,
                $notification->toPush($notifiable)
            );
        }
    }
}
