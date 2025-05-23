<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Performance optimizations -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="application-name" content="{{ config('app.name') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}" crossorigin="use-credentials">

    <!-- App Icons -->
    @if($appIcon ?? false)
        <link rel="icon" href="{{ asset('storage/' . $appIcon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $appIcon) }}">
    @else
        <link rel="icon" href="{{ asset('images/icon-192x192.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192x192.png') }}">
    @endif

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Critical CSS (inlined for performance) -->
    <style>
        /* Base critical styles for immediate rendering */
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            min-height: 100vh;
        }
        .min-h-screen { min-height: 100vh; }
        .bg-white { background-color: white; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .fixed { position: fixed; }
    </style>

    <!-- Fonts with display=swap for better performance -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome (load async for less blocking) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" media="print" onload="this.media='all'" />
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    </noscript>

    <!-- Styles -->
    @livewireStyles
    @vite(['resources/css/app.css'])

    <!-- Stack Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Loading Indicator -->
    <div wire:loading wire:target="navigate" class="fixed top-0 left-0 right-0 z-50">
        <div class="h-1 bg-indigo-600 transition-all duration-300" style="width: 100%"></div>
    </div>

    <div class="min-h-screen bg-gray-100 flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            <div wire:loading.remove wire:target="navigate">
                {{ $slot }}
            </div>
            <div wire:loading wire:target="navigate" class="flex items-center justify-center min-h-[200px]">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name') }}.
                    </div>
                    <div class="text-sm text-gray-500">
                        Developed by <a href="https://fb.com/armanaazij" target="_blank"
                            class="text-indigo-600 hover:text-indigo-800">Arman Azij</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 space-y-4">
    </div>

    <!-- Scripts -->
    @stack('scripts')
    @livewireScripts
    @vite(['resources/js/app.js'])

    <script>
        // Show notifications with performance optimizations
        const showNotification = (() => {
            // Cache DOM reference
            let container;
            
            return function(message, type = 'info') {
                // Get container reference just once and cache it
                if (!container) {
                    container = document.getElementById('notification-container');
                }
                
                const notification = document.createElement('div');
                notification.className = `max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 ${
                    type === 'success' ? 'border-l-4 border-green-500' :
                    type === 'error' ? 'border-l-4 border-red-500' :
                    'border-l-4 border-blue-500'
                }`;

                notification.innerHTML = `
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-1 ml-3">
                                <p class="text-sm text-gray-900">${message}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <span class="sr-only">Close</span>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.appendChild(notification);

                // Use requestAnimationFrame for smoother animations
                requestAnimationFrame(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(10px)';
                    
                    requestAnimationFrame(() => {
                        notification.style.transition = 'opacity 300ms, transform 300ms';
                        notification.style.opacity = '1';
                        notification.style.transform = 'translateY(0)';
                    });
                });

                // Auto remove after 5 seconds
                const timerId = setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(10px)';
                    
                    // Remove DOM element after animation completes
                    setTimeout(() => notification.remove(), 300);
                }, 5000);

                // Remove on click and clear timer
                notification.querySelector('button').addEventListener('click', () => {
                    clearTimeout(timerId);
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(10px)';
                    
                    // Remove DOM element after animation completes
                    setTimeout(() => notification.remove(), 300);
                });
            };
        })();

        // Livewire Navigation Progress Indicator
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('navigating', () => {
                const progressBar = document.createElement('div')
                progressBar.className = 'fixed top-0 left-0 h-1 w-full bg-indigo-600'
                progressBar.style.width = '0'
                progressBar.style.transition = 'width 300ms ease'
                document.body.appendChild(progressBar)

                // Use requestAnimationFrame for smoother animation
                requestAnimationFrame(() => {
                    progressBar.style.width = '0';
                    
                    requestAnimationFrame(() => {
                        progressBar.style.width = '100%';
                    });
                });

                Livewire.on('navigated', () => {
                    progressBar.style.width = '100%'
                    setTimeout(() => {
                        progressBar.remove()
                    }, 300)
                })
            })
        })
    </script>

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification('{{ session('error') }}', 'error');
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification('{{ session('success') }}', 'success');
        });
    </script>
    @endif
</body>
</html> 