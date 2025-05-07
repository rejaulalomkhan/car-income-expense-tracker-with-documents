<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class CheckExpiringDocuments extends Command
{
    protected $signature = 'documents:check-expiring';
    protected $description = 'Check for documents that are expiring soon and send notifications';

    public function handle(NotificationService $notificationService)
    {
        $this->info('Checking for expiring documents...');
        $notificationService->checkExpiringDocuments();
        $this->info('Document check completed.');
    }
}
