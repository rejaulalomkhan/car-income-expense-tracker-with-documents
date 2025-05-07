<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateVapidKeys extends Command
{
    protected $signature = 'vapid:generate';
    protected $description = 'Generate VAPID keys for web push notifications';

    public function handle()
    {
        $this->info('Generating VAPID keys...');

        // Generate random bytes for public and private keys
        $publicKey = $this->base64UrlEncode(random_bytes(32));
        $privateKey = $this->base64UrlEncode(random_bytes(32));

        // Update .env file
        $envFile = base_path('.env');
        $envContents = File::get($envFile);

        // Add or update VAPID keys
        if (!str_contains($envContents, 'VAPID_PUBLIC_KEY=')) {
            $envContents .= "\nVAPID_PUBLIC_KEY=$publicKey";
        } else {
            $envContents = preg_replace(
                '/VAPID_PUBLIC_KEY=.*/',
                "VAPID_PUBLIC_KEY=$publicKey",
                $envContents
            );
        }

        if (!str_contains($envContents, 'VAPID_PRIVATE_KEY=')) {
            $envContents .= "\nVAPID_PRIVATE_KEY=$privateKey";
        } else {
            $envContents = preg_replace(
                '/VAPID_PRIVATE_KEY=.*/',
                "VAPID_PRIVATE_KEY=$privateKey",
                $envContents
            );
        }

        File::put($envFile, $envContents);

        $this->info('VAPID keys have been generated and saved to your .env file');
        $this->info('Public Key: ' . $publicKey);
        return 0;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
