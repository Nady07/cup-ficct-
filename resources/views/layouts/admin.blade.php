<!DOCTYPE html>
<html lang="es" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true',
    sidebarOpen: true 
}" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | CUP FICCT I/2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
               class="bg-gray-900 dark:bg-dark-surface text-white flex flex-col shadow-xl transition-all duration-300 relative">
            <!-- Logo -->
            <div class="p-5 border-b border-gray-700/50 flex items-center justify-between">
                <div x-show="sidebarOpen">
                    <h1 class="text-xl font-bold text-ficct-gold">🎓 CUP FICCT</h1>
                    <p class="text-xs text-gray-400 mt-1">Gestión I/2025</p>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 space-y-1">
                <p x-show="sidebarOpen" class="px-4 text-xs text-gray-500 uppercase tracking-wider mb-2">Principal</p>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <p x-show="sidebarOpen" class="px-4 text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">Académico</p>
                <a href="{{ route('admin.materias.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.materias.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span x-show="sidebarOpen">Materias</span>
                </a>
                <a href="{{ route('admin.grupos.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.grupos.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span x-show="sidebarOpen">Grupos</span>
                </a>
                <a href="{{ route('admin.calificaciones.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.calificaciones.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span x-show="sidebarOpen">Calificaciones</span>
                </a>

                <p x-show="sidebarOpen" class="px-4 text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">Personas</p>
                <a href="{{ route('admin.docentes.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.docentes.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span x-show="sidebarOpen">Docentes</span>
                </a>
                <a href="{{ route('admin.estudiantes.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.estudiantes.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="sidebarOpen">Estudiantes</span>
                </a>

                <p x-show="sidebarOpen" class="px-4 text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">Administración</p>
                <a href="{{ route('admin.carreras.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.carreras.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span x-show="sidebarOpen">Carreras</span>
                </a>
                <a href="{{ route('admin.requisitos.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.requisitos.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span x-show="sidebarOpen">Requisitos</span>
                </a>
                <a href="{{ route('admin.inscripciones.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.inscripciones.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span x-show="sidebarOpen">Inscripciones</span>
                </a>

                <p x-show="sidebarOpen" class="px-4 text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2">Reportes</p>
                <a href="{{ route('admin.reportes.postulantes') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('admin.reportes.*') ? 'bg-gray-800 border-l-4 border-ficct-gold text-ficct-gold' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span x-show="sidebarOpen">Reportes</span>
                </a>
            </nav>

            <!-- User + Logout -->
            <div class="p-4 border-t border-gray-700/50">
                <div class="flex items-center gap-2 mb-3" x-show="sidebarOpen">
                    <div class="w-8 h-8 rounded-full bg-ficct-blue flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrador</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="flex-1 text-xs bg-gray-700 hover:bg-gray-600 text-white px-2 py-1.5 rounded transition-colors">
                        <span x-show="darkMode">☀️</span>
                        <span x-show="!darkMode">🌙</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button class="w-full text-xs bg-red-600 hover:bg-red-700 text-white px-2 py-1.5 rounded transition-colors">
                            🚪 Salir
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white dark:bg-dark-surface border-b border-gray-200 dark:border-dark-border flex-shrink-0">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">@yield('title', 'Panel Admin')</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Success Alert -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 rounded-xl flex justify-between items-center animate-slide-in-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Error Alert -->
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 rounded-xl flex justify-between items-center animate-slide-in-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 rounded-xl animate-slide-in-left">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Errores de validación
                            </h3>
                            <button @click="show = false" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-4 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>