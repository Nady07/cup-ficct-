<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUP FICCT - Curso Preuniversitario</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="w-full max-w-4xl mx-auto px-4 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                <span class="text-white font-bold text-sm">CUP</span>
            </div>
            <div>
                <h1 class="text-lg font-bold">CUP FICCT</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Curso Preuniversitario</p>
            </div>
        </div>
        
        @if (Route::has('login'))
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary text-sm px-4 py-2">
                    Ir al Panel
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Iniciar Sesión
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary text-sm px-4 py-2">
                    Registrarse
                </a>
                @endif
            @endauth
        </nav>
        @endif
    </header>

    {{-- Hero --}}
    <main class="flex-1 flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center space-y-6">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-blue-600 flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">
                Facultad de Ingeniería de Ciencias de la Computación y Telecomunicaciones
            </h1>
            
            <p class="text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                Sistema de administración del Curso Preuniversitario. Gestión de postulantes, calificaciones y admisiones.
            </p>

            <div class="flex flex-wrap justify-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1">📝 4 Materias</span>
                <span>·</span>
                <span class="flex items-center gap-1">📋 3 Exámenes por materia</span>
                <span>·</span>
                <span class="flex items-center gap-1">✅ Nota mínima 60 pts</span>
            </div>

            @if (!Route::has('login') || Auth::check())
            <div class="pt-4">
                <a href="{{ url('/dashboard') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 text-lg">
                    Ingresar al Sistema
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-center py-6 text-xs text-gray-400">
        CUP FICCT · Gestión I/2025 · {{ date('Y') }}
    </footer>
</body>
</html>