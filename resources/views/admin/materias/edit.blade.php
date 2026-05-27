@extends('layouts.admin')

@section('title', 'Editar Materia')

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar Materia
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $materia->nombre }} · {{ $materia->codigo }}</p>
        </div>

        <form action="{{ route('admin.materias.update', $materia) }}" method="POST" class="p-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo', $materia->codigo) }}" class="input-ficct font-mono" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nota Mínima *</label>
                    <input type="number" name="nota_minima" value="{{ old('nota_minima', $materia->nota_minima) }}" min="0" max="100" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Valor Puntaje *</label>
                    <input type="number" name="valor_puntaje" value="{{ old('valor_puntaje', $materia->valor_puntaje) }}" min="0" max="100" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Orden *</label>
                    <input type="number" name="orden" value="{{ old('orden', $materia->orden) }}" min="1" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Estado</label>
                    <select name="estado" class="input-ficct">
                        <option value="1" {{ $materia->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$materia->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                    <textarea name="descripcion" rows="3" class="input-ficct">{{ old('descripcion', $materia->descripcion) }}</textarea>
                </div>
            </div>

            <!-- Info adicional -->
            <div class="mt-6 p-4 bg-gray-50 dark:bg-dark-bg rounded-lg">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Última actualización: {{ $materia->updated_at ? $materia->updated_at->format('d/m/Y H:i') : 'Sin registro' }}</span>                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-dark-border">
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Actualizar Materia
                </button>
                <a href="{{ route('admin.materias.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection