let deferredPrompt;
const installButton = document.getElementById('pwa-install');

// Register Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { scope: '/' })
            .then(registration => {
                console.log('ServiceWorker registration successful');

                // Check for updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            showNotification('App update available. Refresh to update.', 'info');
                        }
                    });
                });
            })
            .catch(error => {
                console.error('ServiceWorker registration failed:', error);
            });
    });
}

// Handle PWA installation
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installButton.classList.remove('hidden');
});

window.addEventListener('appinstalled', () => {
    installButton.classList.add('hidden');
    deferredPrompt = null;
    showNotification('App installed successfully!', 'success');
});

// Installation handler
window.installPWA = async () => {
    if (!deferredPrompt) {
        return;
    }

    try {
        const result = await deferredPrompt.prompt();
        console.log(`Install prompt result: ${result.outcome}`);
        deferredPrompt = null;
    } catch (error) {
        console.error('Error installing PWA:', error);
        showNotification('Failed to install app. Please try again.', 'error');
    }
};

// Handle offline/online status
window.addEventListener('online', () => {
    document.body.classList.remove('offline');
    showNotification('You are back online!', 'success');
});

window.addEventListener('offline', () => {
    document.body.classList.add('offline');
    showNotification('You are offline. Some features may be limited.', 'warning');
});

// Check initial online status
if (!navigator.onLine) {
    document.body.classList.add('offline');
}
