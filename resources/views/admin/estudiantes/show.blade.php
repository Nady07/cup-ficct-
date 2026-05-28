@extends('layouts.admin')

@section('title', 'Perfil del Estudiante')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <a href="{{ route('admin.estudiantes.index') }}" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Volver
            </a>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $estudiante->nombreCompleto() }}</h1>
            <p class="text-xs text-gray-500">CI: {{ $estudiante->ci }}</p>
        </div>
        <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" class="btn-primary text-xs px-3 py-1.5 inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- BARRA DE PROGRESO DEL FLUJO (NUEVO) --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Progreso del Postulante</h3>
        
        @php
            $pasos = [
                'postulante'           => ['label' => 'Postulante',       'icon' => '📝'],
                'requisitos_aprobados' => ['label' => 'Requisitos ✅',    'icon' => '📋'],
                'pago_confirmado'      => ['label' => 'Pago 💰',         'icon' => '💳'],
                'inscrito'             => ['label' => 'Inscrito 📚',     'icon' => '🏫'],
                'cup_aprobado'         => ['label' => 'CUP 🎓',          'icon' => '🎉'],
            ];
            $claves = array_keys($pasos);
            $actual = array_search($estudiante->estado_flujo ?? 'postulante', $claves);
            if ($actual === false) $actual = 0;
        @endphp
        
        <div class="flex items-center gap-1">
            @foreach($pasos as $key => $paso)
                @php $i = array_search($key, $claves); @endphp
                <div class="flex-1 text-center">
                    <div class="w-7 h-7 mx-auto rounded-full text-xs flex items-center justify-center font-bold
                        {{ $i <= $actual ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                        {{ $i + 1 }}
                    </div>
                    <p class="text-[9px] mt-1 {{ $i <= $actual ? 'text-green-600 dark:text-green-400 font-medium' : 'text-gray-400' }}">
                        {{ $paso['icon'] }}<br>{{ $paso['label'] }}
                    </p>
                </div>
                @if(!$loop->last)
                    <div class="w-3 h-0.5 mt-[-12px] {{ $i < $actual ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                @endif
            @endforeach
        </div>

        {{-- Botones de acción según estado --}}
        <div class="mt-3 flex flex-wrap gap-2">
            @if($estudiante->estado_flujo === 'postulante' && $estudiante->requisitos_completos)
                <form action="{{ route('admin.estudiantes.aprobarRequisitos', $estudiante) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="btn-primary text-xs px-3 py-1.5">✅ Aprobar Requisitos</button>
                </form>
            @endif
            
            @if($estudiante->estado_flujo === 'requisitos_aprobados')
                <form action="{{ route('admin.estudiantes.confirmarPago', $estudiante) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="btn-primary text-xs px-3 py-1.5">💳 Confirmar Pago</button>
                </form>
            @endif
            
            {{-- Marcar requisitos como completos --}}
            @if(!$estudiante->requisitos_completos)
                <form action="{{ route('admin.estudiantes.updateRequisitos', $estudiante) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <input type="hidden" name="requisitos_completos" value="1">
                    <button class="btn-secondary text-xs px-3 py-1.5">📋 Marcar Requisitos Completos</button>
                </form>
            @else
                <form action="{{ route('admin.estudiantes.updateRequisitos', $estudiante) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <input type="hidden" name="requisitos_completos" value="0">
                    <button class="btn-secondary text-xs px-3 py-1.5">❌ Desmarcar Requisitos</button>
                </form>
            @endif
        </div>
    </div>

    {{-- Estado General del CUP --}}
    <div class="bg-white dark:bg-gray-900 border rounded-lg p-4 {{ $aprobadoCUP ? 'border-green-500' : 'border-yellow-500' }}">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $aprobadoCUP ? 'bg-green-100 dark:bg-green-900/30' : 'bg-yellow-100 dark:bg-yellow-900/30' }}">
                    <span class="text-2xl">{{ $aprobadoCUP ? '🎓' : '📚' }}</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold">{{ $aprobadoCUP ? '¡CUP APROBADO!' : 'CUP EN CURSO' }}</h3>
                    <p class="text-xs text-gray-500">{{ $aprobadas }} de {{ $totalMaterias }} materias ({{ $porcentajeCompletado }}%)</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold {{ $promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($promedio, 1) }}</p>
                <p class="text-xs text-gray-500">Promedio</p>
            </div>
        </div>
        <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="h-2 rounded-full {{ $porcentajeCompletado >= 100 ? 'bg-green-500' : ($porcentajeCompletado >= 50 ? 'bg-yellow-500' : 'bg-blue-500') }}" 
                 style="width: {{ $porcentajeCompletado }}%"></div>
        </div>
    </div>

    {{-- Grid: Datos + Inscripción + Carrera --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Datos Personales --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Datos Personales</h3>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Nombre</span>
                    <span class="font-medium text-right">{{ $estudiante->nombreCompleto() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">CI</span>
                    <span class="font-mono">{{ $estudiante->ci }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Nacimiento</span>
                    <span>{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Email</span>
                    <span>{{ $estudiante->email }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-gray-500">Teléfono</span>
                    <span>{{ $estudiante->telefono ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500">Colegio</span>
                    <span>{{ $estudiante->colegio_procedencia ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Inscripción --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Inscripción CUP</h3>
            @if($estudiante->inscripcion)
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-gray-500">Estado</span>
                        <x-badge :color="match($estudiante->inscripcion->estado){'confirmado'=>'green','pendiente'=>'yellow',default=>'gray'}">
                            {{ ucfirst($estudiante->inscripcion->estado) }}
                        </x-badge>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-gray-500">Grupo</span>
                        <span class="font-mono font-bold">{{ $estudiante->inscripcion->grupo->codigo ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-gray-500">Docente</span>
                        <span>{{ $estudiante->inscripcion->grupo->docente->nombreCompleto ?? '—' }}</span>
                    </div>
                </div>
            @else
                <p class="text-xs text-gray-400 text-center py-4">No inscrito</p>
            @endif
        </div>

        {{-- Carrera --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Carrera</h3>
            @if($estudiante->carreraInteres)
                <span class="inline-flex px-2 py-0.5 rounded text-xs font-mono font-bold bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                    {{ $estudiante->carreraInteres->codigo }}
                </span>
                <p class="text-sm font-medium mt-1">{{ $estudiante->carreraInteres->nombre }}</p>
                <p class="text-xs text-gray-500">{{ $estudiante->carreraInteres->duracion }}</p>
            @else
                <p class="text-xs text-gray-400">No definida</p>
            @endif
        </div>
    </div>

    {{-- Calificaciones --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Calificaciones ({{ $aprobadas }}/{{ $totalMaterias }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($materias as $materia)
                @php $cal = $estudiante->calificaciones->where('materia_id', $materia->id)->first(); @endphp
                <div class="p-3 rounded-lg border text-xs {{ $cal ? ($cal->estado === 'aprobado' ? 'border-green-200 bg-green-50 dark:bg-green-950/20' : 'border-red-200 bg-red-50 dark:bg-red-950/20') : 'border-gray-200 bg-gray-50 dark:bg-gray-800/50' }}">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">{{ $materia->nombre }}</span>
                        @if($cal)
                            <span class="font-bold {{ $cal->estado === 'aprobado' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $cal->promedio_formateado }}
                            </span>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection