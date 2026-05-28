@extends('layouts.admin')
@section('title', 'Editar Carrera')
@section('content')
<div class="max-w-lg mx-auto space-y-4">
    <a href="{{ route('admin.carreras.index') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Volver</a>
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800"><h2 class="text-sm font-semibold">Editar: {{ $carrera->nombre }}</h2></div>
        <form action="{{ route('admin.carreras.update', $carrera) }}" method="POST" class="p-4 space-y-3">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-3">
                <x-input name="nombre" label="Nombre *" :value="old('nombre', $carrera->nombre)" required />
                <x-input name="codigo" label="Código *" :value="old('codigo', $carrera->codigo)" required />
                <x-input name="titulo_otorgado" label="Título *" :value="old('titulo_otorgado', $carrera->titulo_otorgado)" required />
                <x-input name="duracion" label="Duración *" :value="old('duracion', $carrera->duracion)" required />
                <x-input name="cupos" label="Cupos *" type="number" :value="old('cupos', $carrera->cupos)" min="1" required />
            </div>
            <div class="flex gap-2 justify-end pt-2 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.carreras.index') }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection