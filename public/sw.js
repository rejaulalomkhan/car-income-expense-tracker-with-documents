const CACHE_NAME = 'car-expense-tracker-v3';
const STATIC_CACHE = `${CACHE_NAME}-static`;
const DYNAMIC_CACHE = `${CACHE_NAME}-dynamic`;
const ASSET_CACHE = `${CACHE_NAME}-assets`;

// Get the base path - important for cPanel subdirectory installations
// This will be set when the service worker is installed
let BASE_PATH = '/';

// Assets that should be cached immediately on install
// These will be prefixed with BASE_PATH when caching
const PRECACHE_ASSETS = [
    '',
    'offline.html',
    'css/app.css',
    'js/app.js',
    'manifest.json'
];

// Cache strategies
const CACHE_STRATEGIES = {
    // Cache-first strategy: try cache first, fall back to network
    cacheFirst: async (cacheName, request) => {
        const cache = await caches.open(cacheName);
        const cachedResponse = await cache.match(request);
        
        if (cachedResponse) {
            return cachedResponse;
        }
        
        try {
            const networkResponse = await fetch(request.clone());
            // Only cache valid responses
            if (networkResponse && networkResponse.status === 200) {
                await cache.put(request, networkResponse.clone());
            }
            return networkResponse;
        } catch (error) {
            console.error('Cache-first strategy failed for:', request.url, error);
            return new Response('Network error', { status: 408 });
        }
    },
    
    // Network-first strategy: try network first, fall back to cache
    networkFirst: async (cacheName, request) => {
        try {
            // Try network first
            const networkResponse = await fetch(request.clone());
            
            if (networkResponse && networkResponse.status === 200) {
                // Cache the successful response
                const cache = await caches.open(cacheName);
                await cache.put(request, networkResponse.clone());
                return networkResponse;
            }
            
            throw new Error('Network response was not ok');
        } catch (error) {
            console.log('Network request failed, falling back to cache:', request.url);
            
            // Fall back to cache
            const cache = await caches.open(cacheName);
            const cachedResponse = await cache.match(request);
            
            if (cachedResponse) {
                return cachedResponse;
            }
            
            // If not in cache and we're navigating to a page, show offline page
            if (request.mode === 'navigate') {
                return caches.match('/offline.html');
            }
            
            return new Response('Network and cache both failed', { status: 503 });
        }
    },
    
    // Stale-while-revalidate: return from cache, then update cache
    staleWhileRevalidate: async (cacheName, request) => {
        const cache = await caches.open(cacheName);
        const cachedResponse = await cache.match(request);
        
        // Return cached response immediately 
        if (cachedResponse) {
            // Fetch in the background to update cache
            fetch(request.clone())
                .then(response => {
                    if (response && response.status === 200) {
                        cache.put(request, response.clone());
                    }
                })
                .catch(error => console.error('Background fetch failed:', error));
                
            return cachedResponse;
        }
        
        // If not in cache, fetch from network
        try {
            const networkResponse = await fetch(request.clone());
            if (networkResponse && networkResponse.status === 200) {
                await cache.put(request, networkResponse.clone());
            }
            return networkResponse;
        } catch (error) {
            console.error('Stale-while-revalidate strategy failed:', error);
            // Return offline page for navigation
            if (request.mode === 'navigate') {
                return caches.match('/offline.html');
            }
            return new Response('Failed to fetch', { status: 408 });
        }
    }
};

// Install Service Worker
self.addEventListener('install', event => {
    console.log('[ServiceWorker] Installing new version');
    
    // Determine base path based on the service worker's location
    const swPath = self.location.pathname;
    const pathSegments = swPath.split('/');
    pathSegments.pop(); // Remove 'sw.js'
    BASE_PATH = pathSegments.join('/') + '/';
    
    // For sites in the domain root, ensure a trailing slash
    if (BASE_PATH === '') {
        BASE_PATH = '/';
    }
    
    console.log('[ServiceWorker] Base path set to:', BASE_PATH);
    
    // Create full URLs for precache assets
    const assetsToCache = PRECACHE_ASSETS.map(asset => 
        BASE_PATH + asset
    );
    
    console.log('[ServiceWorker] Assets to cache:', assetsToCache);
    
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('[ServiceWorker] Caching app shell and static assets');
                return cache.addAll(assetsToCache.map(url => new Request(url, { cache: 'reload' })));
            })
            .then(() => {
                console.log('[ServiceWorker] Installation complete, resources cached');
                return self.skipWaiting();
            })
            .catch(error => {
                console.error('[ServiceWorker] Installation failed:', error);
            })
    );
});

// Activate and clean up old caches
self.addEventListener('activate', event => {
    console.log('[ServiceWorker] Activating new version');
    const currentCaches = [STATIC_CACHE, DYNAMIC_CACHE, ASSET_CACHE];
    
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return cacheNames.filter(cacheName => 
                    cacheName.startsWith('car-expense-tracker-') && 
                    !currentCaches.includes(cacheName)
                );
            })
            .then(cachesToDelete => {
                return Promise.all(
                    cachesToDelete.map(cacheToDelete => {
                        console.log('[ServiceWorker] Deleting outdated cache:', cacheToDelete);
                        return caches.delete(cacheToDelete);
                    })
                );
            })
            .then(() => {
                console.log('[ServiceWorker] Claiming clients');
                return self.clients.claim();
            })
            .catch(error => {
                console.error('[ServiceWorker] Activation failed:', error);
            })
    );
});

// Handle fetch events with appropriate strategies
self.addEventListener('fetch', event => {
    // Skip cross-origin requests to reduce errors
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }
    
    const request = event.request;
    const url = new URL(request.url);
    
    // Skip non-GET requests and chrome-extension:// requests
    if (request.method !== 'GET' || !request.url.startsWith('http')) {
        return;
    }
    
    // Skip analytics, Livewire messages and debug requests
    if (url.pathname.includes('analytics') || 
        url.pathname.includes('livewire/message') || 
        url.pathname.includes('_debugbar')) {
        return;
    }
    
    // For offline fallback, adjust the path to include BASE_PATH
    let offlineFallback = BASE_PATH + 'offline.html';
    
    // Handle manifest.json with special CORS handling
    if (url.pathname.endsWith('/manifest.json')) {
        event.respondWith(CACHE_STRATEGIES.staleWhileRevalidate(STATIC_CACHE, request));
        return;
    }
    
    // Handle API requests (use network-first)
    if (url.pathname.includes('/api/')) {
        event.respondWith(CACHE_STRATEGIES.networkFirst(DYNAMIC_CACHE, request));
        return;
    }
    
    // Handle JavaScript and CSS files (use cache-first)
    if (url.pathname.endsWith('.js') || url.pathname.endsWith('.css')) {
        event.respondWith(CACHE_STRATEGIES.cacheFirst(ASSET_CACHE, request));
        return;
    }
    
    // Handle image files (use stale-while-revalidate)
    if (request.destination === 'image' || url.pathname.match(/\.(png|jpe?g|gif|svg|webp)$/)) {
        event.respondWith(CACHE_STRATEGIES.staleWhileRevalidate(ASSET_CACHE, request));
        return;
    }
    
    // Handle font files (use cache-first)
    if (request.destination === 'font' || url.pathname.match(/\.(woff2?|ttf|eot)$/)) {
        event.respondWith(CACHE_STRATEGIES.cacheFirst(ASSET_CACHE, request));
        return;
    }
    
    // HTML navigation - use network-first for dynamic content
    if (request.mode === 'navigate' || request.destination === 'document') {
        event.respondWith(
            CACHE_STRATEGIES.networkFirst(STATIC_CACHE, request)
                .catch(() => {
                    // If both network and cache fail, return the offline page
                    return caches.match(offlineFallback);
                })
        );
        return;
    }
    
    // Default: use stale-while-revalidate
    event.respondWith(CACHE_STRATEGIES.staleWhileRevalidate(DYNAMIC_CACHE, request));
});

// Handle push notifications (if needed)
self.addEventListener('push', event => {
    if (!event.data) return;
    
    try {
        const data = event.data.json();
        
        const options = {
            body: data.body || 'New notification',
            icon: '/icons/icon-192x192.png',
            badge: '/icons/icon-72x72.png',
            vibrate: [100, 50, 100],
            data: {
                url: data.url || '/'
            }
        };
        
        event.waitUntil(
            self.registration.showNotification(data.title || 'Car Expense Tracker', options)
        );
    } catch (error) {
        console.error('[ServiceWorker] Push notification error:', error);
    }
});

// Handle notification clicks
self.addEventListener('notificationclick', event => {
    event.notification.close();
    
    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});

// Background sync for offline forms (if needed)
self.addEventListener('sync', event => {
    if (event.tag === 'sync-expenses' || event.tag === 'sync-incomes') {
        console.log('[ServiceWorker] Background sync triggered:', event.tag);
        // Implement your sync logic here
    }
});
