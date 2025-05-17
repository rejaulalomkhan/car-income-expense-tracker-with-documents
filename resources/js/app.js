import './bootstrap';
import 'flatpickr/dist/flatpickr.css';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Performance optimization - initialize Alpine and register service worker
document.addEventListener('DOMContentLoaded', () => {
    // Defer non-critical operations
    setTimeout(() => {
        // Register performance monitoring
        registerPerformanceObserver();
        
        // Register the service worker (after page loads)
        registerServiceWorker();
    }, 100);
    
    // Initialize Alpine.js (critical for UI)
    initializeAlpine();
});

// Alpine.js initialization with performance improvements
function initializeAlpine() {
    // Check if Alpine is already running
    if (window.Alpine && window.Alpine.__initialized) {
        console.warn('Alpine.js is already initialized. Skipping to prevent multiple instances.');
        return;
    }
    
    // Set up performance markers
    performance.mark('alpine-init-start');
    
    // Check if Alpine is defined but not initialized
    if (window.Alpine && !window.Alpine.__initialized) {
        window.Alpine.__initialized = true;
        window.Alpine.start();
        
        performance.mark('alpine-init-end');
        performance.measure('Alpine initialization', 'alpine-init-start', 'alpine-init-end');
        return;
    }
    
    // Normal initialization
    window.Alpine = Alpine;
    window.Alpine.__initialized = true;
    
    // Add default directives and plugins
    Alpine.plugin(focus);
    
    // Start Alpine
    Alpine.start();
    
    performance.mark('alpine-init-end');
    performance.measure('Alpine initialization', 'alpine-init-start', 'alpine-init-end');
}

// Register service worker with improved error handling and recovery
function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) return;
    
    // Check if site is running on localhost (for development)
    const isLocalhost = 
        window.location.hostname === 'localhost' || 
        window.location.hostname === '127.0.0.1';
    
    // Get the base path for the service worker (for cPanel subdirectory installations)
    const basePath = getBasePath();
    
    // Options for service worker registration
    const options = {
        scope: basePath,
        updateViaCache: 'none'
    };
    
    // First, unregister any existing service workers to avoid conflicts
    if (isLocalhost) {
        try {
            navigator.serviceWorker.getRegistrations()
                .then(registrations => {
                    for (const registration of registrations) {
                        console.log('Unregistering existing service worker during development:', registration.scope);
                        registration.unregister();
                    }
                    
                    // Register fresh after unregistering
                    registerFreshServiceWorker();
                })
                .catch(error => {
                    console.warn('Failed to unregister existing service workers:', error);
                    // Proceed with registration anyway
                    registerFreshServiceWorker();
                });
        } catch (e) {
            console.warn('Error while managing service workers:', e);
            registerFreshServiceWorker();
        }
    } else {
        // In production, just register or update
        registerFreshServiceWorker();
    }
    
    // Helper function to get the base path
    function getBasePath() {
        // Default path
        let path = '/';
        
        // Get the current URL and extract the path part
        const fullPath = window.location.pathname;
        
        // Check if we're in a subdirectory
        if (fullPath && fullPath !== '/') {
            // For cPanel subdirectory installations
            // This handles cases where the app is in a subdirectory like /car-expense-tracker/
            const segments = fullPath.split('/').filter(Boolean);
            if (segments.length > 0) {
                // Get the first segment which should be the app directory
                path = '/' + segments[0] + '/';
            }
        }
        
        console.log('Service Worker base path:', path);
        return path;
    }
    
    // Register a fresh service worker
    function registerFreshServiceWorker() {
        // Use cache busting and the correct base path
        const swPath = `${basePath}sw.js?v=${Date.now()}`;
        console.log('Registering service worker at:', swPath);
        
        navigator.serviceWorker.register(swPath, options)
            .then(registration => {
                console.log('ServiceWorker registration successful with scope:', registration.scope);
                
                // Add update handler
                registration.addEventListener('updatefound', () => {
                    // Track new service worker installation
                    const newWorker = registration.installing;
                    
                    newWorker.addEventListener('statechange', () => {
                        console.log('Service worker state changed:', newWorker.state);
                        
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New version available
                            if (confirm('New version available! Reload to update?')) {
                                window.location.reload();
                            }
                        }
                    });
                });
                
                // Check for updates
                if (isLocalhost) {
                    // Check more frequently in development
                    setInterval(() => {
                        try {
                            registration.update();
                        } catch (e) {
                            console.warn('Failed to update service worker:', e);
                        }
                    }, 30 * 1000);
                } else {
                    // Check less frequently in production
                    setInterval(() => {
                        try {
                            registration.update();
                        } catch (e) {
                            console.warn('Failed to update service worker:', e);
                        }
                    }, 60 * 60 * 1000);
                }
            })
            .catch(error => {
                console.error('ServiceWorker registration failed:', error);
                
                // If in development mode, provide additional debugging info
                if (isLocalhost) {
                    console.log('Try opening the Service Worker fix page: ' + basePath + 'service-worker-fix.html');
                }
            });
    }
}

// Performance monitoring
function registerPerformanceObserver() {
    if (!('PerformanceObserver' in window)) return;
    
    try {
        // Create performance observer for page load metrics
        const perfObserver = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                // Log only critical metrics (FCP, LCP, CLS, etc)
                if (['largest-contentful-paint', 'first-contentful-paint', 
                     'cumulative-layout-shift', 'first-input-delay'].includes(entry.entryType)) {
                    console.log(`[Performance] ${entry.name}: ${entry.startTime.toFixed(0)}ms`);
                }
            }
        });
        
        // Observe performance metrics
        perfObserver.observe({ entryTypes: ['paint', 'layout-shift', 'first-input', 'largest-contentful-paint'] });
    } catch (e) {
        console.warn('Performance API error:', e);
    }
    
    // Log navigation timing metrics
    if (window.performance && window.performance.timing) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const timing = performance.timing;
                const pageLoadTime = timing.loadEventEnd - timing.navigationStart;
                console.log(`[Performance] Total page load time: ${pageLoadTime}ms`);
            }, 0);
        });
    }
}
