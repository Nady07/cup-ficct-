<!DOCTYPE html>
<html lang="es" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') | CUP FICCT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Mejor legibilidad en pantallas grandes */
        @media (min-width: 1536px) {
            .dashboard-grid { grid-template-columns: 2fr 1fr; }
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        
{{-- ═══════════════ NAVBAR ELEGANTE ═══════════════ --}}
<header class="sticky top-0 z-40">
    <nav class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl shadow-black/20">
        <div class="px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                {{-- Logo --}}
                <a href="{{ route('estudiante.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20 group-hover:bg-white/20 transition-all duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-base font-semibold tracking-tight">CUP FICCT</h1>
                        <p class="text-[11px] text-slate-400 font-medium tracking-wide">Gestión I/2027</p>
                    </div>
                </a>

                {{-- Menú Desktop --}}
                <div class="hidden md:flex items-center gap-1">
                    @php
                        $links = [
                            ['route' => 'estudiante.dashboard', 'label' => 'Inicio'],
                            ['route' => 'estudiante.horario', 'label' => 'Horario'],
                            ['route' => 'estudiante.calificaciones', 'label' => 'Notas'],
                            ['route' => 'estudiante.docentes', 'label' => 'Docentes'],
                        ];
                    @endphp
                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300
                                  {{ request()->routeIs($link['route']) 
                                      ? 'text-white bg-white/15' 
                                      : 'text-slate-300 hover:text-white hover:bg-white/8' }}">
                            {{ $link['label'] }}
                            @if(request()->routeIs($link['route']))
                                <span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-blue-400 rounded-full"></span>
                            @endif
                        </a>
                    @endforeach
                </div>

                {{-- Acciones derecha --}}
                <div class="flex items-center gap-1">
                    {{-- Notificaciones --}}
                    <div class="relative" x-data="{ open: false }" x-cloak>
                        <button @click="open = !open" 
                                class="relative p-2.5 text-slate-400 hover:text-white hover:bg-white/8 rounded-xl transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(!auth()->user()->estudiante->requisitos_completos)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-slate-900"></span>
                            @endif
                        </button>
                        {{-- Dropdown --}}
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
                            <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Notificaciones</span>
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700/50">
                                @if(!auth()->user()->estudiante->requisitos_completos)
                                    <div class="px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Documentos pendientes</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Completa la subida de requisitos para continuar</p>
                                                <p class="text-[10px] text-gray-400 mt-1.5">Hace 1 hora</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(auth()->user()->estudiante->estado_flujo === 'requisitos_aprobados')
                                    <div class="px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Requisitos aprobados</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ya puedes realizar el pago del CUP</p>
                                                <p class="text-[10px] text-gray-400 mt-1.5">Hace 2 horas</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tema --}}
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2.5 text-slate-400 hover:text-white hover:bg-white/8 rounded-xl transition-all duration-300"
                            title="Cambiar apariencia">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    {{-- Perfil --}}
                    <div class="hidden lg:flex items-center gap-3 pl-3 ml-2 border-l border-white/10">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-xs font-bold ring-2 ring-blue-500/20">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-200 hidden xl:block">{{ auth()->user()->name }}</span>
                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="p-2.5 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all duration-300"
                                title="Cerrar sesión">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>

                    {{-- Hamburguesa --}}
                    <button @click="mobileMenu = !mobileMenu" 
                            class="md:hidden p-2.5 text-slate-400 hover:text-white hover:bg-white/8 rounded-xl transition-all duration-300">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Menú Móvil --}}
            <div x-show="mobileMenu" x-transition x-cloak class="md:hidden border-t border-white/8 py-4 space-y-1">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                              {{ request()->routeIs($link['route']) ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <div class="pt-3 mt-3 border-t border-white/8">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

        {{-- Contenido (ocupa todo el ancho disponible) --}}
        <main class="flex-1 w-full p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-400">
                <p>CUP FICCT · Gestión I/2025</p>
                <p>FICCT-UAGRM</p>
            </div>
        </footer>
    </div>
</body>
</html>