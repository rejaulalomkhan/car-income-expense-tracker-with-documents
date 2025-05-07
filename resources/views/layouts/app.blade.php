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

    <!-- Primary Styles -->
    @livewireStyles
    @vite(['resources/css/app.css'])

    <!-- Deferred Scripts -->
    @vite(['resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
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
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Dynamic Scripts -->
    @stack('scripts')
    @livewireScripts

    <!-- Livewire Navigation Progress Indicator -->
    <script>
        Livewire.on('navigating', () => {
            const progressBar = document.createElement('div')
            progressBar.className = 'fixed top-0 left-0 h-1 w-full bg-indigo-600'
            progressBar.style.width = '0'
            progressBar.style.transition = 'width 300ms ease'
            document.body.appendChild(progressBar)

            setTimeout(() => {
                progressBar.style.width = '100%'
            }, 100)

            Livewire.on('navigated', () => {
                progressBar.style.width = '100%'
                setTimeout(() => {
                    progressBar.remove()
                }, 300)
            })
        })
    </script>
</body>

</html>
