@extends('layouts.admin')

@section('title', 'Nueva Materia')

@section('content')
<div class="max-w-lg mx-auto space-y-4">
    {{-- Volver --}}
    <a href="{{ route('admin.materias.index') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver
    </a>

    {{-- Formulario --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Nueva Materia</h2>
        </div>

        <form action="{{ route('admin.materias.store') }}" method="POST" class="p-4 space-y-3">
            @csrf
            
            <div class="grid grid-cols-2 gap-3">
                <x-input name="nombre" label="Nombre *" :value="old('nombre')" placeholder="Matemáticas" required />
                <x-input name="codigo" label="Código *" :value="old('codigo')" placeholder="CUP-MAT" required />
                <x-input name="nota_minima" label="Nota Mínima *" type="number" :value="old('nota_minima', 60)" min="0" max="100" required />
                <x-input name="valor_puntaje" label="Valor Puntaje *" type="number" :value="old('valor_puntaje', 25)" min="0" max="100" required />
                <x-input name="orden" label="Orden *" type="number" :value="old('orden', 1)" min="1" required />
            </div>
            
            <div>
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Descripción</label>
                <textarea name="descripcion" rows="2" class="input-ficct text-xs" placeholder="Breve descripción...">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Botones --}}
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.materias.index') }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection