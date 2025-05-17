<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PWAMiddleware
{
    /**
     * Cache durations for different asset types (in seconds)
     */
    protected const CACHE_DURATIONS = [
        'css' => 604800,       // 1 week for CSS
        'js' => 604800,        // 1 week for JS
        'images' => 2592000,   // 30 days for images
        'fonts' => 2592000,    // 30 days for fonts
        'manifest' => 86400,   // 1 day for manifest
        'html' => 0,           // No caching for HTML (always fresh)
        'default' => 3600      // 1 hour default
    ];
    
    /**
     * Get cache duration based on content type
     */
    protected function getCacheDuration(Request $request, string $path): int
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        if (in_array($extension, ['css', 'min.css'])) {
            return self::CACHE_DURATIONS['css'];
        }
        
        if (in_array($extension, ['js', 'min.js'])) {
            return self::CACHE_DURATIONS['js'];
        }
        
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'])) {
            return self::CACHE_DURATIONS['images'];
        }
        
        if (in_array($extension, ['woff', 'woff2', 'ttf', 'eot'])) {
            return self::CACHE_DURATIONS['fonts'];
        }
        
        if ($path === 'manifest.json') {
            return self::CACHE_DURATIONS['manifest'];
        }
        
        if ($extension === 'html' || $extension === '') {
            return self::CACHE_DURATIONS['html'];
        }
        
        return self::CACHE_DURATIONS['default'];
    }
    
    /**
     * Handle the request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $path = $request->path();
        
        // Add Server-Timing headers for performance monitoring
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        $totalTime = (microtime(true) - $startTime) * 1000;
        $response->headers->set('Server-Timing', "app;dur={$totalTime}");
        
        // Get the origin for CORS handling
        $origin = $request->header('Origin');
        $host = $request->getHost();
        
        // Handle specific asset types
        if ($request->is('manifest.json') ||
            $request->is('sw.js') ||
            $request->is('offline.html') ||
            $request->is('icons/*')) {
            
            // Add PWA-related headers
            $response->headers->set('Service-Worker-Allowed', '/');
            
            // CORS handling
            if ($origin) {
                $originHost = parse_url($origin, PHP_URL_HOST);
                
                // Check if origin matches host or is a local development URL
                if ($originHost === $host || 
                    in_array($originHost, ['localhost', '127.0.0.1']) || 
                    in_array($host, ['localhost', '127.0.0.1'])) {
                    $response->headers->set('Access-Control-Allow-Origin', $origin);
                } else {
                    // Allow specific development origins
                    $allowedOrigins = [
                        'http://localhost:8000',
                        'http://127.0.0.1:8000',
                        'https://localhost:8000',
                        'https://127.0.0.1:8000',
                    ];
                    
                    if (in_array($origin, $allowedOrigins)) {
                        $response->headers->set('Access-Control-Allow-Origin', $origin);
                    } elseif (app()->environment('local', 'development')) {
                        $response->headers->set('Access-Control-Allow-Origin', '*');
                    }
                }
            } else {
                $response->headers->set('Access-Control-Allow-Origin', '*');
            }
            
            // Add standard CORS headers
            $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Accept');
            $response->headers->set('Access-Control-Max-Age', '86400');
            
            // Add caching headers based on file type
            $cacheDuration = $this->getCacheDuration($request, $path);
            if ($cacheDuration > 0) {
                $response->headers->set('Cache-Control', "public, max-age={$cacheDuration}, stale-while-revalidate=86400");
                
                // Add expires header 
                $expires = gmdate('D, d M Y H:i:s', time() + $cacheDuration) . ' GMT';
                $response->headers->set('Expires', $expires);
            } else {
                // No caching for HTML content
                $response->headers->set('Cache-Control', 'no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
            }
        }
        
        // Add content security policy header (if not already set)
        if (!$response->headers->has('Content-Security-Policy') && !app()->environment('local')) {
            // Add a secure CSP policy (customize as needed)
            $response->headers->set('Content-Security-Policy', 
                "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; " . 
                "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://cdnjs.cloudflare.com; " .
                "img-src 'self' data:; " .
                "font-src 'self' https://fonts.bunny.net https://cdnjs.cloudflare.com; " .
                "connect-src 'self'"
            );
        }
        
        // Set X-Frame-Options to prevent clickjacking
        if (!$response->headers->has('X-Frame-Options')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        }
        
        // Set X-Content-Type-Options to prevent MIME-type sniffing
        if (!$response->headers->has('X-Content-Type-Options')) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
        }
        
        return $response;
    }
}
