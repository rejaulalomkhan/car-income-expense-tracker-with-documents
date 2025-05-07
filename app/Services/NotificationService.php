<?php

namespace App\Services;

use App\Models\CarDocument;
use App\Models\CompanyDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DocumentExpiryNotification;
use App\Models\User;

class NotificationService
{
    public function checkExpiringDocuments()
    {
        $this->checkExpiringCarDocuments();
        $this->checkExpiringCompanyDocuments();
    }

    private function checkExpiringCarDocuments()
    {
        $nearExpiryDate = Carbon::now()->addDays(30);

        $expiringDocuments = CarDocument::where('document_expiry_date', '<=', $nearExpiryDate)
            ->where('document_expiry_date', '>', Carbon::now())
            ->where('notification_sent', false)
            ->get();

        foreach ($expiringDocuments as $document) {
            $this->sendExpiryNotification($document);
            $document->update(['notification_sent' => true]);
        }
    }

    private function checkExpiringCompanyDocuments()
    {
        $nearExpiryDate = Carbon::now()->addDays(30);

        $expiringDocuments = CompanyDocument::where('expiry_date', '<=', $nearExpiryDate)
            ->where('expiry_date', '>', Carbon::now())
            ->where('notification_sent', false)
            ->get();

        foreach ($expiringDocuments as $document) {
            $this->sendExpiryNotification($document);
            $document->update(['notification_sent' => true]);
        }
    }

    private function sendExpiryNotification($document)
    {
        $users = User::all();
        Notification::send($users, new DocumentExpiryNotification($document));
    }
}
