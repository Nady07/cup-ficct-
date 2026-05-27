@extends('layouts.admin')

@section('title', 'Editar Carrera')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.carreras.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a carreras
        </a>
    </div>

    <div class="card">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar: {{ $carrera->nombre }}
        </h2>

        <form action="{{ route('admin.carreras.update', $carrera) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $carrera->nombre) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo', $carrera->codigo) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Duración *</label>
                    <input type="text" name="duracion" value="{{ old('duracion', $carrera->duracion) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Título Otorgado *</label>
                    <input type="text" name="titulo_otorgado" value="{{ old('titulo_otorgado', $carrera->titulo_otorgado) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Estado</label>
                    <select name="estado" class="input-ficct">
                        <option value="1" {{ $carrera->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$carrera->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="input-ficct">{{ old('descripcion', $carrera->descripcion) }}</textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Actualizar Carrera
                </button>
                <a href="{{ route('admin.carreras.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection