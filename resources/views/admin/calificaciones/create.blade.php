@extends('layouts.admin')

@section('title', 'Nueva Calificación')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto space-y-6">
    <a href="{{ route('admin.calificaciones.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver
    </a>

    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-dark-border">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Nueva Calificación</h2>
        </div>
        <form action="{{ route('admin.calificaciones.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Estudiante</label>
                <select name="estudiante_id" required class="input-ficct">
                    <option value="">Seleccionar...</option>
                    @foreach($estudiantes as $e)
                        <option value="{{ $e->id }}">{{ $e->apellidos }} {{ $e->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Materia</label>
                <select name="materia_id" required class="input-ficct">
                    <option value="">Seleccionar...</option>
                    @foreach($materias as $m)
                        <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">1er Examen</label>
                    <input type="number" name="nota1" step="0.01" min="0" max="100" required class="input-ficct text-center" placeholder="0-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">2do Examen</label>
                    <input type="number" name="nota2" step="0.01" min="0" max="100" required class="input-ficct text-center" placeholder="0-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">3er Examen</label>
                    <input type="number" name="nota3" step="0.01" min="0" max="100" required class="input-ficct text-center" placeholder="0-100">
                </div>
            </div>
            <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-dark-border">
                <button type="submit" class="btn-primary">Guardar</button>
                <a href="{{ route('admin.calificaciones.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection