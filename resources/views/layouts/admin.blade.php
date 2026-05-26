<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CUP FICCT') - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">CUP FICCT</h1>
                <p class="text-sm text-gray-400">Panel Administrativo</p>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.materias.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.materias.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    📚 Materias
                </a>
                <a href="{{ route('admin.grupos.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.grupos.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    👥 Grupos
                </a>
                <a href="{{ route('admin.docentes.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.docentes.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    👨‍🏫 Docentes
                </a>
                <a href="{{ route('admin.carreras.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.carreras.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    🎓 Carreras
                </a>
                <a href="{{ route('admin.requisitos.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.requisitos.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    📋 Requisitos
                </a>
                <a href="{{ route('admin.estudiantes.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.estudiantes.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    🧑‍🎓 Estudiantes
                </a>
                <a href="{{ route('admin.calificaciones.index') }}" 
                   class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.calificaciones.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    📝 Calificaciones
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>