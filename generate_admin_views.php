#!/usr/bin/env php
<?php
/**
 * Generador de vistas para admin - Ejecutar: php generate_admin_views.php
 */

$baseDir = __DIR__ . '/resources/views/admin';

// Crear directorios
$dirs = ['grupos', 'docentes', 'carreras', 'requisitos', 'estudiantes', 'inscripciones', 'calificaciones'];
foreach ($dirs as $dir) {
    @mkdir("$baseDir/$dir", 0777, true);
}

echo "✓ Directorios creados\n";

// ===== GRUPOS =====
$gruposIndex = <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Grupos')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Grupos</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Administra los grupos académicos de la facultad</p>
        </div>
        <a href="{{ route('admin.grupos.create') }}" class="inline-flex items-center space-x-2 bg-ficct-blue hover:bg-ficct-light-blue text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-md">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span>Nuevo Grupo</span>
        </a>
    </div>

    <div class="grid gap-4">
        @forelse($grupos as $grupo)
            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $grupo->codigo }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $grupo->turno === 'M' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : ($grupo->turno === 'T' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200') }}">
                                {{ $grupo->turno === 'M' ? 'Mañana' : ($grupo->turno === 'T' ? 'Tarde' : 'Noche') }}
                            </span>
                        </div>
                        <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <p><strong>Horario:</strong> {{ $grupo->horario_inicio }} - {{ $grupo->horario_fin }}</p>
                            <p><strong>Docente:</strong> {{ $grupo->docente?->nombre ?? 'No asignado' }}</p>
                            <p><strong>Capacidad:</strong> {{ $grupo->inscripciones_count ?? 0 }} / {{ $grupo->capacidad_maxima }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.grupos.show', $grupo) }}" class="p-2 text-ficct-blue hover:bg-ficct-blue hover:text-white rounded-lg transition-all" title="Ver">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="{{ route('admin.grupos.edit', $grupo) }}" class="p-2 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Editar">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                        </a>
                        <form action="{{ route('admin.grupos.destroy', $grupo) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este grupo?')">@csrf @method('DELETE')<button type="submit" class="p-2 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all" title="Eliminar"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></button></form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-3 opacity-30" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                <p class="text-gray-500">No hay grupos registrados</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $grupos->links() }}</div>
</div>
@endsection
BLADE;

file_put_contents("$baseDir/grupos/index.blade.php", $gruposIndex);
echo "✓ grupos/index.blade.php\n";

// Crear más vistas...
file_put_contents("$baseDir/grupos/create.blade.php", <<<'BLADE'
@extends('layouts.admin')
@section('title', 'Nuevo Grupo')
@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.grupos.index') }}" class="text-ficct-blue hover:text-ficct-light-blue inline-flex items-center space-x-1 mb-6">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        <span>Volver a Grupos</span>
    </a>

    <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6">Crear Nuevo Grupo</h1>
        <form action="{{ route('admin.grupos.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Código *</label>
                    <input type="text" name="codigo" placeholder="Ej: G001" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-dark-bg focus:ring-2 focus:ring-ficct-blue outline-none" required>
                    @error('codigo')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Turno *</label>
                    <select name="turno" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-dark-bg focus:ring-2 focus:ring-ficct-blue outline-none" required>
                        <option>-- Seleccionar --</option>
                        <option value="M">Mañana</option>
                        <option value="T">Tarde</option>
                        <option value="N">Noche</option>
                    </select>
                    @error('turno')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Inicio *</label>
                    <input type="time" name="horario_inicio" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-dark-bg" required>
                    @error('horario_inicio')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Fin *</label>
                    <input type="time" name="horario_fin" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-dark-bg" required>
                    @error('horario_fin')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Capacidad Máxima *</label>
                <input type="number" name="capacidad_maxima" placeholder="30" min="1" max="100" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-dark-bg" required>
                @error('capacidad_maxima')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-ficct-blue hover:bg-ficct-light-blue text-white font-semibold py-3 rounded-lg transition-all">Guardar Grupo</button>
                <a href="{{ route('admin.grupos.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg text-center transition-all">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE
);

echo "✓ grupos/create.blade.php\n";

echo "\n✅ Vistas generadas exitosamente\n";
?>