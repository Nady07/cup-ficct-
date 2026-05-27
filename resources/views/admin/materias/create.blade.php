@extends('layouts.admin')

@section('title', 'Nueva Materia')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto space-y-6">
    <!-- Volver -->
    <a href="{{ route('admin.materias.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a materias
    </a>

    <!-- Formulario -->
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-dark-border">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Registrar Nueva Materia
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Completa todos los campos obligatorios marcados con *</p>
        </div>

        <form action="{{ route('admin.materias.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre de la Materia *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Matemáticas" class="input-ficct" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: CUP-MAT" class="input-ficct font-mono" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nota Mínima para Aprobar *</label>
                    <input type="number" name="nota_minima" value="{{ old('nota_minima', 60) }}" min="0" max="100" class="input-ficct" required>
                    <p class="text-xs text-gray-400 mt-1">Por defecto: 60 puntos</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Valor en Puntaje *</label>
                    <input type="number" name="valor_puntaje" value="{{ old('valor_puntaje', 25) }}" min="0" max="100" class="input-ficct" required>
                    <p class="text-xs text-gray-400 mt-1">Peso de la materia (total 100 pts entre todas)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Orden *</label>
                    <input type="number" name="orden" value="{{ old('orden', 1) }}" min="1" class="input-ficct" required>                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                    <textarea name="descripcion" rows="3" class="input-ficct" placeholder="Breve descripción del contenido de la materia...">{{ old('descripcion') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-dark-border">
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Materia
                </button>
                <a href="{{ route('admin.materias.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection