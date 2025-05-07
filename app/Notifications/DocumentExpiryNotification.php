<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;

class DocumentExpiryNotification extends Notification
{
    use Queueable;

    protected $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', WebPushChannel::class];
    }

    public function toMail($notifiable)
    {
        $documentType = get_class($this->document) === 'App\Models\CarDocument' ? 'Car' : 'Company';
        $expiryDate = $documentType === 'Car' ? $this->document->document_expiry_date : $this->document->expiry_date;
        $title = $documentType === 'Car'
            ? "{$this->document->car->name} - {$this->document->document_type}"
            : $this->document->title;

        return (new MailMessage)
            ->subject("Document Expiration Notice - {$title}")
            ->line("This is a reminder that the following {$documentType} document will expire soon:")
            ->line("Document: {$title}")
            ->line("Expiry Date: " . $expiryDate->format('d M, Y'))
            ->action('View Document', url('/documents/' . strtolower($documentType)))
            ->line('Please take necessary actions to renew the document before it expires.');
    }

    public function toArray($notifiable)
    {
        $documentType = get_class($this->document) === 'App\Models\CarDocument' ? 'Car' : 'Company';
        $expiryDate = $documentType === 'Car' ? $this->document->document_expiry_date : $this->document->expiry_date;

        return [
            'document_id' => $this->document->id,
            'document_type' => $documentType,
            'title' => $documentType === 'Car'
                ? "{$this->document->car->name} - {$this->document->document_type}"
                : $this->document->title,
            'expiry_date' => $expiryDate->format('Y-m-d'),
        ];
    }

    public function toPush($notifiable)
    {
        $documentType = get_class($this->document) === 'App\Models\CarDocument' ? 'Car' : 'Company';
        $expiryDate = $documentType === 'Car' ? $this->document->document_expiry_date : $this->document->expiry_date;
        $title = $documentType === 'Car'
            ? "{$this->document->car->name} - {$this->document->document_type}"
            : $this->document->title;

        return [
            'title' => 'Document Expiring Soon',
            'body' => "{$title} will expire on " . $expiryDate->format('d M, Y'),
            'action_url' => url('/documents/' . strtolower($documentType)),
            'icon' => '/icons/icon-192x192.png',
            'badge' => '/icons/icon-72x72.png'
        ];
    }
}
