<!DOCTYPE html>
<html lang="es" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CUP FICCT') - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white transition-colors duration-200">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-ficct-dark-blue dark:bg-dark-surface text-white flex flex-col border-r border-ficct-blue dark:border-dark-border">
            <!-- Header -->
            <div class="p-6 border-b border-ficct-blue dark:border-dark-border">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-ficct-gold rounded-lg flex items-center justify-center">
                        <span class="text-ficct-dark-blue font-bold text-lg">F</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">FICCT</h1>
                        <p class="text-xs text-blue-200">Panel Admin</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" clip-rule="evenodd"></path></svg>
                        <span>📊 Dashboard</span>
                    </span>
                </a>

                <!-- Divider -->
                <div class="h-px bg-ficct-blue bg-opacity-20 my-4"></div>
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider px-4 py-2">Académico</div>

                <a href="{{ route('admin.materias.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.materias.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">📚 Materias</span>
                </a>

                <a href="{{ route('admin.grupos.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.grupos.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">👥 Grupos</span>
                </a>

                <a href="{{ route('admin.docentes.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.docentes.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">👨‍🏫 Docentes</span>
                </a>

                <a href="{{ route('admin.estudiantes.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.estudiantes.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">🧑‍🎓 Estudiantes</span>
                </a>

                <!-- Divider -->
                <div class="h-px bg-ficct-blue bg-opacity-20 my-4"></div>
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider px-4 py-2">Configuración</div>

                <a href="{{ route('admin.carreras.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.carreras.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">🎓 Carreras</span>
                </a>

                <a href="{{ route('admin.requisitos.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.requisitos.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">📋 Requisitos</span>
                </a>

                <!-- Divider -->
                <div class="h-px bg-ficct-blue bg-opacity-20 my-4"></div>
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider px-4 py-2">Gestión</div>

                <a href="{{ route('admin.inscripciones.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.inscripciones.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">📝 Inscripciones</span>
                </a>

                <a href="{{ route('admin.calificaciones.index') }}" 
                   class="block px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.calificaciones.*') ? 'bg-ficct-blue text-white' : 'hover:bg-ficct-blue hover:bg-opacity-20 text-blue-100' }}">
                    <span class="flex items-center space-x-3">📊 Calificaciones</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-ficct-blue dark:border-dark-border space-y-3">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark')" 
                        class="w-full px-4 py-2 bg-ficct-blue hover:bg-ficct-light-blue text-white font-medium rounded-lg transition-all">
                    🌙 Tema
                </button>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition-all">
                        🚪 Salir
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <div class="bg-white dark:bg-dark-surface border-b border-gray-200 dark:border-dark-border sticky top-0 z-10">
                <div class="p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('title', 'Panel Admin')</h2>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ auth()->user()->name }} 👤
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 dark:bg-opacity-20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 dark:bg-opacity-20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg flex justify-between items-center">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 dark:bg-opacity-20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg">
                        <h3 class="font-semibold mb-2">Errores encontrados:</h3>
                        <ul class="list-disc list-inside space-y-1">
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
</body>
</html>