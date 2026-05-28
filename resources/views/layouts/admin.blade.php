<!DOCTYPE html>
<html lang="es" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | CUP FICCT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        
        {{-- SIDEBAR --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
               class="bg-[#0f172a] dark:bg-gray-900 text-white flex flex-col transition-all duration-300 relative z-20 shadow-xl">
            
            {{-- Logo --}}
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700/50 dark:border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">C</span>
                    </div>
                    <div x-show="sidebarOpen" class="min-w-0">
                        <h1 class="text-sm font-bold text-white truncate">CUP FICCT</h1>
                        <p class="text-[10px] text-gray-400">I/2025</p>
                    </div>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-1.5 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 overflow-y-auto p-3 space-y-1">
                
                {{-- ═══════════════ MENÚ PRINCIPAL ═══════════════ --}}
                @php
                    $menu = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'url' => route('admin.dashboard'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ];
                    
                    $secciones = [
                        'Académico' => [
                            ['label' => 'Materias', 'route' => 'admin.materias.*', 'url' => route('admin.materias.index'), 'icon' => 'M12 6.253v13...'],
                            ['label' => 'Grupos', 'route' => 'admin.grupos.*', 'url' => route('admin.grupos.index'), 'icon' => 'M19 11H5...'],
                            ['label' => 'Calificaciones', 'route' => 'admin.calificaciones.*', 'url' => route('admin.calificaciones.index'), 'icon' => 'M9 19v-6...'],
                        ],
                        'Personas' => [
                            ['label' => 'Docentes', 'route' => 'admin.docentes.*', 'url' => route('admin.docentes.index'), 'icon' => 'M16 7a4...', 'submenu' => [
                                ['label' => 'Aprobados', 'route' => 'admin.docentes.index'],
                                ['label' => 'Postulantes', 'route' => 'admin.docentes.postulantes', 'badge' => \App\Models\Docente::whereIn('estado_postulacion', ['pendiente', 'en_revision'])->count()],
                            ]],
                            ['label' => 'Estudiantes', 'route' => 'admin.estudiantes.*', 'url' => route('admin.estudiantes.index'), 'icon' => 'M17 20h5v-2...', 'submenu' => [
                                ['label' => 'Inscritos', 'route' => 'admin.estudiantes.index'],
                                ['label' => 'Postulantes', 'route' => 'admin.estudiantes.postulantes', 'badge' => \App\Models\Estudiante::whereIn('estado_flujo', ['postulante', 'requisitos_aprobados'])->count()],
                            ]],
                        ],
                        'Administración' => [
                            ['label' => 'Inscripciones', 'route' => 'admin.inscripciones.*', 'url' => route('admin.inscripciones.index'), 'icon' => 'M9 12h6...'],
                            ['label' => 'Carreras', 'route' => 'admin.carreras.*', 'url' => route('admin.carreras.index'), 'icon' => 'M19 21V5...'],
                            ['label' => 'Requisitos', 'route' => 'admin.requisitos.*', 'url' => route('admin.requisitos.index'), 'icon' => 'M9 5H7...'],
                        ],
                        'Reportes' => [
                            ['label' => 'Reportes', 'route' => 'admin.reportes.*', 'url' => route('admin.reportes.postulantes'), 'icon' => 'M9 17v-2...'],
                        ],
                    ];
                @endphp

                {{-- Dashboard --}}
                <a href="{{ $menu[0]['url'] }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs($menu[0]['route']) ? 'bg-white/15 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $menu[0]['icon'] }}"/></svg>
                    <span x-show="sidebarOpen" class="truncate">{{ $menu[0]['label'] }}</span>
                </a>

                {{-- Secciones dinámicas --}}
                @foreach($secciones as $titulo => $items)
                    <div x-show="sidebarOpen" class="pt-3 pb-1">
                        <p class="px-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wider">{{ $titulo }}</p>
                    </div>
                    
                    @foreach($items as $item)
                        {{-- Si tiene submenú, mostrar como dropdown simple --}}
                        @if(isset($item['submenu']))
                            <div x-data="{ open: {{ request()->routeIs($item['route']) ? 'true' : 'false' }} }">
                                <button @click="open = !open" 
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                               {{ request()->routeIs($item['route']) ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/></svg>
                                    <span x-show="sidebarOpen" class="truncate flex-1 text-left">{{ $item['label'] }}</span>
                                    <svg x-show="sidebarOpen" :class="open ? 'rotate-90' : ''" class="w-3 h-3 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                                <div x-show="open && sidebarOpen" x-transition class="ml-8 mt-1 space-y-1">
                                    @foreach($item['submenu'] as $sub)
                                        <a href="{{ route($sub['route']) }}" 
                                           class="block px-3 py-1.5 rounded-lg text-xs transition-colors
                                                  {{ request()->routeIs($sub['route']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white' }}">
                                            {{ $sub['label'] }}
                                            @if(isset($sub['badge']) && $sub['badge'] > 0)
                                                <span class="ml-1 bg-amber-400 text-gray-900 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $sub['badge'] }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $item['url'] }}" 
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                      {{ request()->routeIs($item['route']) ? 'bg-white/15 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/></svg>
                                <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                @endforeach
            </nav>

            {{-- Footer --}}
            <div class="p-3 border-t border-gray-700/50 dark:border-gray-800">
                <div class="flex items-center gap-2.5 px-2 mb-3" x-show="sidebarOpen">
                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400">Administrador</p>
                    </div>
                </div>
                <div class="flex gap-1.5">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="flex-1 flex items-center justify-center gap-1 px-2 py-2 text-xs font-medium text-gray-400 hover:bg-white/10 rounded-lg transition-colors">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span x-show="sidebarOpen" class="text-[10px]">Tema</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button class="w-full flex items-center justify-center gap-1 px-2 py-2 text-xs font-medium text-red-400 hover:bg-red-500/20 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span x-show="sidebarOpen" class="text-[10px]">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col overflow-hidden bg-gray-50 dark:bg-gray-950">
            <div class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 flex-shrink-0">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('title', 'Panel')</h1>
                <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                    <span>{{ now()->format('d/m/Y') }}</span>
                    <div class="w-7 h-7 rounded-full bg-[#0f172a] flex items-center justify-center text-white text-[10px] font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg flex justify-between items-center text-xs">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg flex justify-between items-center text-xs">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
                    </div>
                @endif
                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg text-xs">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
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