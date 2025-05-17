// Service Worker Fix Script
// This script will unregister any existing service workers,
// clear caches, and re-register the service worker

// Function to run when the page loads
async function fixServiceWorker() {
    try {
        console.log('Starting Service Worker fix process...');
        
        // Step 1: Unregister all service workers
        await unregisterServiceWorkers();
        
        // Step 2: Clear cache storage
        await clearCacheStorage();
        
        // Step 3: Clear local and session storage
        clearLocalStorage();
        clearSessionStorage();
        
        // Step 4: Re-register the service worker
        await registerServiceWorker();
        
        console.log('Service Worker fix completed successfully!');
        document.getElementById('sw-status').textContent = 'Service Worker fixed successfully!';
        document.getElementById('sw-status').className = 'text-green-500 font-bold';
    } catch (error) {
        console.error('Error fixing Service Worker:', error);
        document.getElementById('sw-status').textContent = 'Error fixing Service Worker: ' + error.message;
        document.getElementById('sw-status').className = 'text-red-500 font-bold';
    }
}

// Unregister all service workers
async function unregisterServiceWorkers() {
    if (!('serviceWorker' in navigator)) {
        throw new Error('Service Worker API not supported in this browser');
    }
    
    console.log('Unregistering service workers...');
    const registrations = await navigator.serviceWorker.getRegistrations();
    
    if (registrations.length === 0) {
        console.log('No service workers to unregister');
        return;
    }
    
    const results = await Promise.all(
        registrations.map(registration => {
            console.log('Unregistering service worker with scope:', registration.scope);
            return registration.unregister();
        })
    );
    
    const success = results.every(result => result === true);
    if (!success) {
        throw new Error('Failed to unregister some service workers');
    }
    
    console.log(`Successfully unregistered ${registrations.length} service worker(s)`);
}

// Clear all caches in cache storage
async function clearCacheStorage() {
    if (!('caches' in window)) {
        throw new Error('Cache Storage API not supported in this browser');
    }
    
    console.log('Clearing cache storage...');
    const cacheNames = await caches.keys();
    
    if (cacheNames.length === 0) {
        console.log('No caches to clear');
        return;
    }
    
    const results = await Promise.all(
        cacheNames.map(cacheName => {
            console.log('Deleting cache:', cacheName);
            return caches.delete(cacheName);
        })
    );
    
    const success = results.every(result => result === true);
    if (!success) {
        throw new Error('Failed to delete some caches');
    }
    
    console.log(`Successfully cleared ${cacheNames.length} cache(s)`);
}

// Clear local storage
function clearLocalStorage() {
    if (!window.localStorage) {
        console.warn('localStorage not supported in this browser');
        return;
    }
    
    console.log('Clearing localStorage...');
    const itemCount = localStorage.length;
    localStorage.clear();
    console.log(`Cleared ${itemCount} item(s) from localStorage`);
}

// Clear session storage
function clearSessionStorage() {
    if (!window.sessionStorage) {
        console.warn('sessionStorage not supported in this browser');
        return;
    }
    
    console.log('Clearing sessionStorage...');
    const itemCount = sessionStorage.length;
    sessionStorage.clear();
    console.log(`Cleared ${itemCount} item(s) from sessionStorage`);
}

// Register service worker
async function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        throw new Error('Service Worker API not supported in this browser');
    }
    
    // Get the base path for the service worker
    const basePath = getBasePath();
    console.log('Using base path for service worker:', basePath);
    
    console.log('Registering service worker...');
    const registration = await navigator.serviceWorker.register(basePath + 'sw.js', {
        scope: basePath,
        updateViaCache: 'none'
    });
    
    console.log('Service Worker registered with scope:', registration.scope);
    return registration;
}

// Helper function to get the base path 
function getBasePath() {
    // Default path
    let path = '/';
    
    // Check if we're in a subdirectory on cPanel
    const scriptPath = document.currentScript ? document.currentScript.src : '';
    if (scriptPath) {
        const url = new URL(scriptPath);
        const pathSegments = url.pathname.split('/');
        // Remove the script filename from the path
        pathSegments.pop();
        
        // For cPanel subdirectory installations
        if (pathSegments.length > 1) {
            path = pathSegments.join('/') + '/';
            // Remove the /public part if present
            path = path.replace('/public/', '/');
        }
    }
    
    return path;
}

// Run the fix when the page loads
document.addEventListener('DOMContentLoaded', fixServiceWorker); 