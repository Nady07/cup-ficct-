@extends('layouts.admin')

@section('title', 'Materias')

@section('content')
<div class="animate-fade-in space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Materias del CUP</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $materias->total() }} materias registradas · Nota mínima 60 pts</p>
        </div>
        <a href="{{ route('admin.materias.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Materia
        </a>
    </div>

    <!-- Grid de Materias -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($materias as $materia)
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md transition-all duration-200 {{ !$materia->estado ? 'opacity-50' : '' }}">
            <div class="p-6">
                <!-- Cabecera -->
                <div class="flex items-start justify-between mb-5">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $materia->nombre }}</h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs font-mono text-gray-400">{{ $materia->codigo }}</span>
                                <span class="text-gray-300">·</span>
                                <span class="text-xs text-gray-400">{{ $materia->valor_puntaje }} pts</span>
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $materia->estado ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                        {{ $materia->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>

                <!-- Métricas -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gray-50 dark:bg-dark-bg rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Orden</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $materia->orden }}°</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-dark-bg rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Nota Mín.</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">≥ {{ $materia->nota_minima }}</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-center">
                        <p class="text-xs text-blue-500 dark:text-blue-400">Puntaje</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $materia->valor_puntaje }} pts</p>
                    </div>
                </div>

                <!-- Descripción -->
                @if($materia->descripcion)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">{{ $materia->descripcion }}</p>
                @endif

                <!-- Acciones -->
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100 dark:border-dark-border">
                    <a href="{{ route('admin.materias.edit', $materia) }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('admin.materias.destroy', $materia) }}" method="POST" onsubmit="return confirm('¿Eliminar esta materia?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-2">
            <div class="bg-white dark:bg-dark-surface rounded-xl border border-dashed border-gray-300 dark:border-gray-600 p-16 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">No hay materias registradas</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Comienza agregando la primera materia del CUP.</p>
                <a href="{{ route('admin.materias.create') }}" class="btn-primary">Crear Materia</a>
            </div>
        </div>
        @endforelse
    </div>

    @if($materias->hasPages())
    <div>{{ $materias->links() }}</div>
    @endif
</div>
@endsection