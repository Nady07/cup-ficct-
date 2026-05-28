@extends('layouts.admin')

@section('title', 'Nuevo Docente')

@section('content')
<div class="max-w-lg mx-auto space-y-4">
    <a href="{{ route('admin.docentes.index') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver
    </a>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-sm font-semibold">Nuevo Docente</h2>
        </div>
        <form action="{{ route('admin.docentes.store') }}" method="POST" class="p-4 space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <x-input name="nombre" label="Nombre *" :value="old('nombre')" required />
                <x-input name="apellidos" label="Apellidos *" :value="old('apellidos')" required />
                <x-input name="ci" label="CI *" :value="old('ci')" required />
                <x-input name="email" label="Email *" type="email" :value="old('email')" required />
                <x-input name="telefono" label="Teléfono" :value="old('telefono')" />
                <x-input name="especialidad" label="Especialidad" :value="old('especialidad')" />
            </div>
            <div>
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Experiencia</label>
                <textarea name="experiencia" rows="2" class="input-ficct text-xs">{{ old('experiencia') }}</textarea>
            </div>
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.docentes.index') }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection