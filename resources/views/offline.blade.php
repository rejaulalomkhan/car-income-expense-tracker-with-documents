<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4 p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center">
            <i class="fas fa-wifi-slash text-6xl text-gray-400 mb-6"></i>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">No Internet Connection</h1>
            <p class="text-gray-600 mb-6">You are currently offline. Some features may be limited.</p>

            <div class="space-y-4">
                <p class="text-sm text-gray-500">While offline you can still:</p>
                <ul class="text-sm text-gray-600 text-left ml-8 list-disc space-y-2">
                    <li>View previously loaded data</li>
                    <li>Access cached pages</li>
                    <li>Create drafts of expenses and incomes</li>
                    <li>View downloaded documents</li>
                </ul>
            </div>

            <button onclick="window.location.reload()"
                class="mt-8 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors inline-flex items-center">
                <i class="fas fa-sync-alt mr-2"></i>
                Try Again
            </button>

            <button onclick="window.history.back()"
                class="mt-4 text-gray-600 hover:text-gray-800 transition-colors block w-full text-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
        </div>
    </div>
    <script>
        window.addEventListener('online', () => {
            window.location.reload();
        });
    </script>
</body>

</html>
