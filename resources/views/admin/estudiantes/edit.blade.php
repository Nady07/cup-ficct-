@extends('layouts.admin')

@section('title', 'Editar Estudiante')

@section('content')
<div class="max-w-4xl mx-auto space-y-4">
    {{-- Volver --}}
    <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver al perfil
    </a>

    <form action="{{ route('admin.estudiantes.update', $estudiante) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        
        {{-- Datos Personales --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Datos Personales</h2>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <x-input name="nombre" label="Nombre *" :value="old('nombre', $estudiante->nombre)" required />
                <x-input name="apellidos" label="Apellidos *" :value="old('apellidos', $estudiante->apellidos)" required />
                <x-input name="ci" label="CI *" :value="old('ci', $estudiante->ci)" required />
                <x-input name="email" label="Email *" type="email" :value="old('email', $estudiante->email)" required />
                <x-input name="telefono" label="Teléfono" :value="old('telefono', $estudiante->telefono)" />
                <x-input name="fecha_nacimiento" label="Fecha Nacimiento *" type="date" :value="old('fecha_nacimiento', $estudiante->fecha_nacimiento->format('Y-m-d'))" required />
                <div class="sm:col-span-2">
                    <x-input name="direccion" label="Dirección" :value="old('direccion', $estudiante->direccion)" />
                </div>
                <x-input name="colegio_procedencia" label="Colegio" :value="old('colegio_procedencia', $estudiante->colegio_procedencia)" />
                <x-input name="anio_graduacion" label="Año Graduación" type="number" :value="old('anio_graduacion', $estudiante->anio_graduacion)" />
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Carrera</label>
                    <select name="carrera_interes_id" class="input-ficct text-xs">
                        <option value="">Sin seleccionar</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}" {{ $estudiante->carrera_interes_id == $carrera->id ? 'selected' : '' }}>{{ $carrera->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                    <select name="estado" class="input-ficct text-xs">
                        <option value="1" {{ $estudiante->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$estudiante->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Inscripción --}}
        @if($estudiante->inscripcion)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Inscripción CUP</h2>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Grupo</label>
                    <select name="grupo_id" class="input-ficct text-xs">
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}" {{ $estudiante->inscripcion->grupo_id == $grupo->id ? 'selected' : '' }}>
                                {{ $grupo->codigo }} ({{ $grupo->turno === 'M' ? 'Mañana' : ($grupo->turno === 'T' ? 'Tarde' : 'Noche') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                    <select name="inscripcion_estado" class="input-ficct text-xs">
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmado" {{ $estudiante->inscripcion->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="rechazado" {{ $estudiante->inscripcion->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
                <x-input name="monto_pagado" label="Monto Pagado (Bs.)" type="number" :value="old('monto_pagado', $estudiante->inscripcion->monto_pagado)" />
                <x-input name="numero_boleta" label="N° Boleta" :value="old('numero_boleta', $estudiante->inscripcion->numero_boleta)" />
            </div>
        </div>
        @endif

        {{-- Botones --}}
        <div class="flex gap-2 justify-end">
            <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="btn-secondary text-xs px-3 py-1.5">Cancelar</a>
            <x-btn-primary :route="null" class="text-xs px-3 py-1.5">
                Guardar Cambios
            </x-btn-primary>
        </div>
    </form>
</div>
@endsection