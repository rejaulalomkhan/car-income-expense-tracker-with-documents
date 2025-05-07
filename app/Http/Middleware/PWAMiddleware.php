<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PWAMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add PWA-related headers
        $response->headers->set('Service-Worker-Allowed', '/');

        // Add offline detection header
        if ($request->header('X-Offline')) {
            $response->headers->set('X-Offline-Response', 'true');
        }

        // Cache control for PWA assets
        if ($request->is('manifest.json') ||
            $request->is('sw.js') ||
            $request->is('offline') ||
            $request->is('icons/*')) {
            $response->headers->set('Cache-Control', 'public, max-age=3600');
        }

        return $response;
    }
}
