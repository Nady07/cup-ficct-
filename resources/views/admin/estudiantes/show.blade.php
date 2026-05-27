@extends('layouts.admin')

@section('title', 'Perfil del Estudiante')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.estudiantes.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver a estudiantes
            </a>
            <h2 class="text-2xl font-bold">{{ $estudiante->nombreCompleto() }}</h2>
            <p class="text-sm text-gray-500">CI: {{ $estudiante->ci }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar Estudiante
            </a>
        </div>
    </div>

    <!-- Estado General del CUP -->
    <div class="card mb-6 {{ $aprobadoCUP ? 'border-l-4 border-green-500' : 'border-l-4 border-yellow-500' }}">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center {{ $aprobadoCUP ? 'bg-green-100' : 'bg-yellow-100' }}">
                    <span class="text-3xl">{{ $aprobadoCUP ? '🎓' : '📚' }}</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold">
                        {{ $aprobadoCUP ? '¡CUP APROBADO!' : 'CUP EN CURSO' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $aprobadas }} de {{ $totalMaterias }} materias aprobadas ({{ $porcentajeCompletado }}%)
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold {{ $promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($promedio, 1) }}
                </p>
                <p class="text-sm text-gray-500">Promedio general</p>
            </div>
        </div>
        <div class="mt-4 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="h-3 rounded-full transition-all {{ $porcentajeCompletado >= 100 ? 'bg-green-500' : ($porcentajeCompletado >= 50 ? 'bg-yellow-500' : 'bg-blue-500') }}" 
                 style="width: {{ $porcentajeCompletado }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna 1: Datos Personales -->
        <div class="card">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Datos Personales
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Nombre completo</span>
                    <span class="font-medium text-right">{{ $estudiante->nombreCompleto() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">CI</span>
                    <span class="font-mono">{{ $estudiante->ci }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Fecha Nacimiento</span>
                    <span>{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Email</span>
                    <span class="text-sm">{{ $estudiante->email }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Teléfono</span>
                    <span>{{ $estudiante->telefono ?? 'No registrado' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Dirección</span>
                    <span class="text-sm text-right">{{ $estudiante->direccion ?? 'No registrada' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                    <span class="text-gray-500">Colegio</span>
                    <span class="text-sm text-right">{{ $estudiante->colegio_procedencia ?? 'No registrado' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Año Graduación</span>
                    <span>{{ $estudiante->anio_graduacion ?? 'No registrado' }}</span>
                </div>
            </div>
        </div>

        <!-- Columna 2: Inscripción al CUP -->
        <div class="card">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Inscripción CUP I/2025
            </h3>
            @if($estudiante->inscripcion)
                @php $insc = $estudiante->inscripcion; @endphp
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Estado</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $insc->estado === 'confirmado' ? 'bg-green-100 text-green-800' : 
                               ($insc->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                               ($insc->estado === 'completado' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($insc->estado) }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Grupo</span>
                        <span class="font-bold font-mono">{{ $insc->grupo->codigo ?? 'No asignado' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Turno</span>
                        <span>{{ $insc->grupo->turno ?? '-' === 'M' ? '🌅 Mañana' : ($insc->grupo->turno ?? '-' === 'T' ? '☀️ Tarde' : '🌙 Noche') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Horario</span>
                        <span>{{ isset($insc->grupo) ? \Carbon\Carbon::parse($insc->grupo->horario_inicio)->format('H:i') . ' - ' . \Carbon\Carbon::parse($insc->grupo->horario_fin)->format('H:i') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Modalidad</span>
                        <span class="badge-ficct">{{ $insc->grupo->modalidad ?? 'Presencial' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Docente</span>
                        <span class="text-sm">{{ $insc->grupo->docente->nombreCompleto ?? $insc->grupo->docente->apellidos ?? 'Sin asignar' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Fecha Inscripción</span>
                        <span>{{ $insc->fecha_inscripcion }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-dark-border">
                        <span class="text-gray-500">Monto Pagado</span>
                        <span class="font-bold">Bs. {{ number_format($insc->monto_pagado ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Boleta N°</span>
                        <span class="font-mono text-sm">{{ $insc->numero_boleta ?? 'N/A' }}</span>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500">No está inscrito en el CUP</p>
                </div>
            @endif
        </div>

        <!-- Columna 3: Carrera y Requisitos -->
        <div class="space-y-6">
            <!-- Carrera -->
            <div class="card">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Carrera de Interés
                </h3>
                @if($estudiante->carreraInteres)
                    <div class="p-3 bg-blue-50 dark:bg-blue-900 dark:bg-opacity-20 rounded-lg">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-mono font-bold">
                            {{ $estudiante->carreraInteres->codigo }}
                        </span>
                        <p class="font-bold mt-2">{{ $estudiante->carreraInteres->nombre }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $estudiante->carreraInteres->duracion }}</p>
                    </div>
                @else
                    <p class="text-gray-500">No ha seleccionado carrera.</p>
                @endif
            </div>

            <!-- Requisitos -->
            <div class="card">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Documentos / Requisitos
                </h3>
                @if($requisitosCompletados)
                    <div class="p-3 bg-green-50 dark:bg-green-900 dark:bg-opacity-20 rounded-lg flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-bold text-green-800">Todos los requisitos completos</span>
                    </div>
                @else
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 rounded-lg flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-bold text-yellow-800">Requisitos pendientes</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Materias y Calificaciones -->
    <div class="card mt-6">
        <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Materias del CUP ({{ $aprobadas }}/{{ $totalMaterias }} aprobadas)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($materias as $materia)
                @php
                    $calificacion = $estudiante->calificaciones->where('materia_id', $materia->id)->first();
                @endphp
                <div class="p-4 rounded-lg border {{ $calificacion ? ($calificacion->estado === 'aprobado' ? 'border-green-300 bg-green-50 dark:bg-green-900 dark:bg-opacity-10' : 'border-red-300 bg-red-50 dark:bg-red-900 dark:bg-opacity-10') : 'border-gray-200 bg-gray-50 dark:bg-dark-surface' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-lg">{{ $materia->nombre }}</h4>
                            <p class="text-xs text-gray-500">{{ $materia->codigo }} • Nota mínima: {{ $materia->nota_minima }}</p>
                            <p class="text-xs text-gray-400">Vale {{ $materia->valor_puntaje }} puntos</p>
                        </div>
                        <div class="text-right">
                            @if($calificacion)
                                <p class="text-3xl font-bold {{ $calificacion->nota >= $materia->nota_minima ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $calificacion->nota }}
                                </p>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $calificacion->estado === 'aprobado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $calificacion->estado === 'aprobado' ? '✅ Aprobado' : '❌ Reprobado' }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">Registrado por: {{ $calificacion->registradoPor->name ?? 'Sistema' }}</p>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    ⏳ Pendiente
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($calificacion)
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $calificacion->nota >= $materia->nota_minima ? 'bg-green-500' : 'bg-red-500' }}" 
                                 style="width: {{ min($calificacion->nota, 100) }}%"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($aprobadoCUP)
            <div class="mt-6 p-4 bg-green-100 dark:bg-green-900 dark:bg-opacity-20 rounded-lg text-center">
                <p class="text-xl font-bold text-green-800 dark:text-green-200">🎓 ¡Felicidades! El estudiante ha APROBADO el CUP</p>
                <p class="text-sm text-green-600 dark:text-green-300">Promedio final: {{ number_format($promedio, 1) }} puntos</p>
            </div>
        @elseif($reprobadas > 0)
            <div class="mt-6 p-4 bg-yellow-100 dark:bg-yellow-900 dark:bg-opacity-20 rounded-lg text-center">
                <p class="text-lg font-bold text-yellow-800 dark:text-yellow-200">⚠️ Atención: Tiene {{ $reprobadas }} materia(s) reprobada(s)</p>
                <p class="text-sm text-yellow-600 dark:text-yellow-300">Necesita aprobar todas las materias con nota ≥ 60</p>
            </div>
        @endif
    </div>
</div>
@endsection