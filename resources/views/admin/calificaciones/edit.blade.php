@extends('layouts.admin')

@section('title', 'Editar Calificación')

@section('content')
<div class="max-w-lg mx-auto space-y-4">
    {{-- Volver --}}
    <a href="{{ route('admin.calificaciones.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver
    </a>

    {{-- Card principal --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        {{-- Header --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Editar Calificación</h2>
        </div>

        {{-- Info estudiante --}}
        <div class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800 flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-xs font-bold text-blue-600">
                {{ strtoupper(substr($calificacion->estudiante->nombre ?? '?', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-gray-900 dark:text-white truncate">
                    {{ $calificacion->estudiante->apellidos ?? '—' }}, {{ $calificacion->estudiante->nombre ?? '' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $calificacion->materia->nombre ?? '—' }}</p>
            </div>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('admin.calificaciones.update', $calificacion) }}" method="POST" class="p-4 space-y-4">
            @csrf @method('PUT')
            
            {{-- Notas en grid responsive --}}
            <div class="grid grid-cols-3 gap-2.5">
                @foreach([1,2,3] as $i)
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Examen {{ $i }}</label>
                    <input type="number" name="nota{{ $i }}" step="0.01" min="0" max="100" 
                           value="{{ old('nota'.$i, $calificacion->{'nota'.$i}) }}" 
                           class="input-ficct text-center text-sm font-semibold" required>
                </div>
                @endforeach
            </div>

            {{-- Vista previa del promedio actual --}}
            <div class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-gray-800/50 rounded text-xs">
                <span class="text-gray-500 dark:text-gray-400">Promedio actual</span>
                <span class="font-bold {{ $calificacion->promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $calificacion->promedio_formateado }}
                </span>
            </div>

            {{-- Botones --}}
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.calificaciones.index') }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection