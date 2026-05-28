@extends('layouts.admin')

@section('title', 'Nueva Calificación')

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
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Nueva Calificación</h2>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('admin.calificaciones.store') }}" method="POST" class="p-4 space-y-3">
            @csrf
            
            {{-- Selects en grid 2 columnas --}}
            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Estudiante</label>
                    <select name="estudiante_id" required class="input-ficct text-xs">
                        <option value="">Seleccionar...</option>
                        @foreach($estudiantes as $e)
                            <option value="{{ $e->id }}">{{ $e->apellidos }}, {{ substr($e->nombre, 0, 1) }}.</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Materia</label>
                    <select name="materia_id" required class="input-ficct text-xs">
                        <option value="">Seleccionar...</option>
                        @foreach($materias as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Notas en grid 3 columnas --}}
            <div class="grid grid-cols-3 gap-2.5">
                @foreach([1,2,3] as $i)
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Examen {{ $i }}</label>
                    <input type="number" name="nota{{ $i }}" step="0.01" min="0" max="100" required 
                           class="input-ficct text-center text-sm font-semibold" placeholder="0-100">
                </div>
                @endforeach
            </div>

            {{-- Botones --}}
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.calificaciones.index') }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection