const CACHE_NAME = 'car-expense-tracker-v1';
const urlsToCache = [
    '/',
    '/offline.html',
    '/css/app.css',
    '/js/app.js'
    // Removed manifest.json from the cache list to prevent CORS issues
];

// Install Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('Opened cache');
                // Cache each URL individually to prevent a single failure from stopping all caching
                return Promise.allSettled(
                    urlsToCache.map(url => 
                        cache.add(url).catch(err => {
                            console.error(`Failed to cache ${url}:`, err);
                        })
                    )
                );
            })
    );
});

// Listen for requests
self.addEventListener('fetch', (event) => {
    // Don't try to handle non-GET requests or those with query params
    if (event.request.method !== 'GET' || event.request.url.includes('livewire/message')) {
        return;
    }
    
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Return cached version or fetch new version
                return response || fetch(event.request)
                    .catch(() => {
                        // If both fail, show offline page
                        if (event.request.mode === 'navigate') {
                            return caches.match('/offline.html');
                        }
                    });
            })
    );
});

// Activate the SW
self.addEventListener('activate', (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
