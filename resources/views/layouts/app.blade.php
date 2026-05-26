<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="darkMode ? 'dark' : ''">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FICCT-CUP') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            // Inicializar tema antes de renderizar para evitar flash
            if (localStorage.getItem('darkMode') === 'true' || 
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-dark-bg text-gray-900 dark:text-dark transition-colors duration-200">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-dark-surface shadow border-b border-gray-200 dark:border-dark-border">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-ficct-dark-blue dark:bg-darker text-white py-8 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">FICCT-UAGRM</h3>
                            <p class="text-sm text-gray-300">Facultad Integral de Ciencia y Tecnología</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Enlaces</h3>
                            <ul class="text-sm text-gray-300 space-y-1">
                                <li><a href="#" class="hover:text-ficct-gold transition">CUP</a></li>
                                <li><a href="#" class="hover:text-ficct-gold transition">Horario</a></li>
                                <li><a href="#" class="hover:text-ficct-gold transition">Materias</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Contacto</h3>
                            <p class="text-sm text-gray-300">ficct@uagrm.edu.bo</p>
                        </div>
                    </div>
                    <div class="border-t border-ficct-blue mt-8 pt-8 text-center text-sm text-gray-400">
                        <p>&copy; 2026 FICCT-UAGRM. Todos los derechos reservados.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
