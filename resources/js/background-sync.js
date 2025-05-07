// Queue names for different types of operations
const QUEUE_NAMES = {
    EXPENSE: 'expense-sync',
    INCOME: 'income-sync',
    DOCUMENT: 'document-sync'
};

// Register background sync for forms
async function registerBackgroundSync(formData, queueName) {
    if (!('serviceWorker' in navigator) || !('SyncManager' in window)) {
        return false;
    }

    try {
        const registration = await navigator.serviceWorker.ready;

        // Store the form data in IndexedDB for later sync
        await storeFormData(queueName, formData);

        // Register the sync
        await registration.sync.register(queueName);

        return true;
    } catch (error) {
        console.error('Background sync registration failed:', error);
        return false;
    }
}

// Store form data in IndexedDB
async function storeFormData(queueName, formData) {
    const db = await openDatabase();
    const transaction = db.transaction(['syncQueue'], 'readwrite');
    const store = transaction.objectStore('syncQueue');

    const data = {
        queueName,
        formData: Object.fromEntries(formData),
        timestamp: new Date().getTime()
    };

    await store.add(data);
}

// Open IndexedDB database
function openDatabase() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('offlineSync', 1);

        request.onerror = () => reject(request.error);
        request.onsuccess = () => resolve(request.result);

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains('syncQueue')) {
                db.createObjectStore('syncQueue', {
                    keyPath: 'id',
                    autoIncrement: true
                });
            }
        };
    });
}

// Add event listeners to forms that need offline support
document.addEventListener('DOMContentLoaded', () => {
    const formsToSync = [
        {
            selector: '#expense-form',
            queueName: QUEUE_NAMES.EXPENSE
        },
        {
            selector: '#income-form',
            queueName: QUEUE_NAMES.INCOME
        },
        {
            selector: '#document-form',
            queueName: QUEUE_NAMES.DOCUMENT
        }
    ];

    formsToSync.forEach(({ selector, queueName }) => {
        const form = document.querySelector(selector);
        if (form) {
            form.addEventListener('submit', async (event) => {
                if (!navigator.onLine) {
                    event.preventDefault();
                    const formData = new FormData(form);

                    if (await registerBackgroundSync(formData, queueName)) {
                        showNotification('Form saved. Will be submitted when you\'re back online.', 'info');
                    } else {
                        showNotification('Unable to save form for offline submission.', 'error');
                    }
                }
            });
        }
    });
});
