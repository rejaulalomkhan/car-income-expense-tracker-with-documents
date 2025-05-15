import './bootstrap';
import 'flatpickr/dist/flatpickr.css';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Prevent multiple Alpine instances
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.plugin(focus);
    Alpine.start();
} else {
    console.warn('Alpine is already defined on window. Skipping initialization to prevent multiple instances.');
}

// Register Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registration successful');
            })
            .catch(error => {
                console.log('ServiceWorker registration failed:', error);
            });
    });
}
