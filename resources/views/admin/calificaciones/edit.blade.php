@extends('layouts.admin')

@section('title', 'Editar Calificación')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.calificaciones.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a calificaciones
    </a>

    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-dark-border">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar Calificación
            </h2>
        </div>

        <!-- Info del estudiante y materia -->
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-dark-bg border-b border-gray-100 dark:border-dark-border">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-400">
                    {{ strtoupper(substr($calificacion->estudiante->nombre ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $calificacion->estudiante->apellidos ?? 'N/A' }} {{ $calificacion->estudiante->nombre ?? '' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $calificacion->materia->nombre ?? 'N/A' }} · {{ $calificacion->materia->codigo ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.calificaciones.update', $calificacion) }}" method="POST" class="p-6">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">1er Examen</label>
                    <input type="number" name="nota1" step="0.01" min="0" max="100" 
                           value="{{ old('nota1', $calificacion->nota1) }}" 
                           class="input-ficct text-center text-lg font-bold" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">2do Examen</label>
                    <input type="number" name="nota2" step="0.01" min="0" max="100" 
                           value="{{ old('nota2', $calificacion->nota2) }}" 
                           class="input-ficct text-center text-lg font-bold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">3er Examen</label>
                    <input type="number" name="nota3" step="0.01" min="0" max="100" 
                           value="{{ old('nota3', $calificacion->nota3) }}" 
                           class="input-ficct text-center text-lg font-bold" required>
                </div>
            </div>

            <!-- Vista previa -->
            <div class="p-4 bg-gray-50 dark:bg-dark-bg rounded-xl mb-6">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Promedio actual</span>
                    <span class="text-xl font-bold {{ $calificacion->promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($calificacion->promedio, 1) }}
                    </span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Estado actual</span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $calificacion->estado === 'aprobado' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ $calificacion->estado === 'aprobado' ? 'Aprobado' : 'Reprobado' }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-dark-border">
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Actualizar Calificación
                </button>
                <a href="{{ route('admin.calificaciones.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection