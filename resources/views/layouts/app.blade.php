<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="darkMode ? 'dark' : ''">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CUP FICCT') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            if (localStorage.getItem('darkMode') === 'true' || 
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-dark-bg text-gray-900 dark:text-white transition-colors duration-200">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-dark-surface shadow border-b border-gray-200 dark:border-dark-border">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="bg-ficct-dark-blue dark:bg-gray-900 text-white py-6 mt-12">
                <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} CUP FICCT-UAGRM · Todos los derechos reservados.</p>
                </div>
            </footer>
        </div>
    </body>
</html>