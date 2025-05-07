<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                @if($appLogo ?? false)
                    <img src="{{ asset('storage/' . $appLogo) }}" alt="{{ config('app.name') }}" class="w-20 h-20 object-contain mx-auto mb-4" />
                @else
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500 mx-auto mb-4" />
                @endif
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    <!-- PWA Notification Popup -->
    <div id="pwa-notification" class="hidden fixed bottom-6 right-6 bg-white border border-indigo-500 shadow-lg rounded-lg p-4 z-50">
        <div class="flex items-center">
            <i class="fas fa-download text-indigo-600 text-2xl mr-3"></i>
            <div>
                <div class="font-semibold text-gray-800 mb-1">Install this app?</div>
                <div class="text-gray-600 text-sm mb-2">Add Car Expense Tracker to your home screen for a better experience.</div>
                <button id="pwa-install-btn" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition">Install</button>
                <button id="pwa-dismiss-btn" class="ml-2 text-gray-500 hover:text-gray-700 text-sm">Dismiss</button>
            </div>
        </div>
    </div>
    <script>
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            document.getElementById('pwa-notification').classList.remove('hidden');
        });
        document.getElementById('pwa-install-btn').addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    document.getElementById('pwa-notification').classList.add('hidden');
                }
                deferredPrompt = null;
            }
        });
        document.getElementById('pwa-dismiss-btn').addEventListener('click', () => {
            document.getElementById('pwa-notification').classList.add('hidden');
        });
    </script>
</body>

</html>
