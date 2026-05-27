@extends('layouts.admin')

@section('title', 'Editar Estudiante')

@section('content')
<div class="animate-fade-in">
    <div class="mb-6">
        <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al perfil
        </a>
    </div>

    <form action="{{ route('admin.estudiantes.update', $estudiante) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Datos Personales -->
            <div class="card">
                <h3 class="text-lg font-bold mb-4">🧑 Datos Personales</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $estudiante->nombre) }}" class="input-ficct" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Apellidos *</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos', $estudiante->apellidos) }}" class="input-ficct" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">CI *</label>
                        <input type="text" name="ci" value="{{ old('ci', $estudiante->ci) }}" class="input-ficct" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $estudiante->email) }}" class="input-ficct" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $estudiante->telefono) }}" class="input-ficct">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Fecha Nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento->format('Y-m-d')) }}" class="input-ficct" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $estudiante->direccion) }}" class="input-ficct">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Colegio</label>
                        <input type="text" name="colegio_procedencia" value="{{ old('colegio_procedencia', $estudiante->colegio_procedencia) }}" class="input-ficct">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Año Graduación</label>
                        <input type="number" name="anio_graduacion" value="{{ old('anio_graduacion', $estudiante->anio_graduacion) }}" class="input-ficct">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Carrera</label>
                        <select name="carrera_interes_id" class="input-ficct">
                            <option value="">Sin seleccionar</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}" {{ $estudiante->carrera_interes_id == $carrera->id ? 'selected' : '' }}>
                                    {{ $carrera->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Estado</label>
                        <select name="estado" class="input-ficct">
                            <option value="1" {{ $estudiante->estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$estudiante->estado ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Inscripción -->
            <div class="card">
                <h3 class="text-lg font-bold mb-4">📝 Inscripción CUP</h3>
                @if($estudiante->inscripcion)
                    @php $insc = $estudiante->inscripcion; @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Grupo</label>
                            <select name="grupo_id" class="input-ficct">
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ $insc->grupo_id == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->codigo }} ({{ $grupo->turno === 'M' ? 'Mañana' : ($grupo->turno === 'T' ? 'Tarde' : 'Noche') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Estado Inscripción</label>
                            <select name="inscripcion_estado" class="input-ficct">
                                <option value="pendiente" {{ $insc->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmado" {{ $insc->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="completado" {{ $insc->estado === 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="rechazado" {{ $insc->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Monto Pagado (Bs.)</label>
                            <input type="number" name="monto_pagado" step="0.01" value="{{ old('monto_pagado', $insc->monto_pagado) }}" class="input-ficct">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">N° Boleta</label>
                            <input type="text" name="numero_boleta" value="{{ old('numero_boleta', $insc->numero_boleta) }}" class="input-ficct">
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">El estudiante aún no tiene inscripción.</p>
                @endif
            </div>
        </div>

        <div class="flex gap-3 mt-6 justify-end">
            <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection