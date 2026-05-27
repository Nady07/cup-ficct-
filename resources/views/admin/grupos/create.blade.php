@extends('layouts.admin')

@section('title', 'Nuevo Grupo')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.grupos.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a grupos
        </a>
    </div>

    <div class="card">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Nuevo Grupo
        </h2>

        <form action="{{ route('admin.grupos.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: M001" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Turno *</label>
                    <select name="turno" class="input-ficct" required>
                        <option value="">Seleccionar turno</option>
                        <option value="M" {{ old('turno') === 'M' ? 'selected' : '' }}>🌅 Mañana</option>
                        <option value="T" {{ old('turno') === 'T' ? 'selected' : '' }}>☀️ Tarde</option>
                        <option value="N" {{ old('turno') === 'N' ? 'selected' : '' }}>🌙 Noche</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Hora Inicio *</label>
                    <input type="time" name="horario_inicio" value="{{ old('horario_inicio') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Hora Fin *</label>
                    <input type="time" name="horario_fin" value="{{ old('horario_fin') }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Capacidad Máxima *</label>
                    <input type="number" name="capacidad_maxima" value="{{ old('capacidad_maxima', 60) }}" class="input-ficct" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Docente</label>
                    <select name="docente_id" class="input-ficct">
                        <option value="">Sin asignar</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                {{ $docente->apellidos }} {{ $docente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Grupo
                </button>
                <a href="{{ route('admin.grupos.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection