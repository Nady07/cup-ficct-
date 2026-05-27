@extends('layouts.admin')

@section('title', 'Perfil del Docente')

@section('content')
<div class="animate-fade-in space-y-6">
    <!-- Volver -->
    <a href="{{ route('admin.docentes.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a docentes
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna 1: Perfil -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Datos Personales -->
            <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/40 flex items-center justify-center text-2xl font-bold text-purple-700 dark:text-purple-300 mx-auto shadow-sm">
                        {{ strtoupper(substr($docente->nombre, 0, 1)) }}{{ strtoupper(substr($docente->apellidos, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-4">{{ $docente->apellidos }}, {{ $docente->nombre }}</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $docente->estado ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-300' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300' }}">
                        {{ $docente->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-50 dark:border-dark-border">
                        <span class="text-gray-500">CI</span>
                        <span class="font-mono font-medium text-gray-900 dark:text-white">{{ $docente->ci }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50 dark:border-dark-border">
                        <span class="text-gray-500">Email</span>
                        <span class="text-gray-900 dark:text-white">{{ $docente->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50 dark:border-dark-border">
                        <span class="text-gray-500">Teléfono</span>
                        <span class="text-gray-900 dark:text-white">{{ $docente->telefono ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50 dark:border-dark-border">
                        <span class="text-gray-500">Especialidad</span>
                        <span class="font-medium text-gray-900 dark:text-white text-right">{{ $docente->especialidad ?? 'No especificada' }}</span>
                    </div>
                    <div class="py-2">
                        <span class="text-gray-500 block mb-1">Experiencia</span>
                        <p class="text-gray-900 dark:text-white">{{ $docente->experiencia ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>

            <!-- Requisitos del Docente -->
<div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Requisitos Presentados
                </h3>
                <span class="text-sm font-medium {{ $requisitosCompletos === $totalRequisitos ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $requisitosCompletos }}/{{ $totalRequisitos }}
                </span>
            </div>
            <!-- Panel de Revisión de Postulación -->
<div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
    <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Revisión de Postulación
    </h3>

    <!-- Estado actual -->
    <div class="flex items-center gap-3 mb-4">
        <span class="text-sm text-gray-500">Estado:</span>
        @php
            $colores = [
                'pendiente' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'en_revision' => 'bg-blue-50 text-blue-700 border-blue-200',
                'aprobado' => 'bg-green-50 text-green-700 border-green-200',
                'rechazado' => 'bg-red-50 text-red-700 border-red-200',
            ];
        @endphp
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $colores[$docente->estado_postulacion] }}">
            {{ ucfirst($docente->estado_postulacion) }}
        </span>
    </div>

    <!-- Requisitos obligatorios -->
    <div class="mb-4 p-4 bg-gray-50 dark:bg-dark-bg rounded-lg">
        <p class="text-sm font-medium mb-2">
            Requisitos obligatorios: 
            @if($docente->cumpleRequisitosObligatorios())
                <span class="text-green-600">✅ Cumple todos</span>
            @else
                <span class="text-red-600">❌ Faltan requisitos</span>
            @endif
        </p>
    </div>

    <!-- Formulario para cambiar estado -->
    <form action="{{ route('admin.docentes.updateEstadoPostulacion', $docente) }}" method="POST" class="space-y-3">
        @csrf @method('PATCH')
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Cambiar estado</label>
            <select name="estado_postulacion" class="input-ficct">
                <option value="pendiente" {{ $docente->estado_postulacion === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_revision" {{ $docente->estado_postulacion === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                <option value="aprobado" {{ $docente->estado_postulacion === 'aprobado' ? 'selected' : '' }}>✅ Aprobar</option>
                <option value="rechazado" {{ $docente->estado_postulacion === 'rechazado' ? 'selected' : '' }}>❌ Rechazar</option>
            </select>
        </div>
        <div id="motivoRechazo" class="{{ $docente->estado_postulacion === 'rechazado' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Motivo de rechazo</label>
            <textarea name="motivo_rechazo" rows="2" class="input-ficct" placeholder="Explicar por qué se rechaza...">{{ $docente->motivo_rechazo }}</textarea>
        </div>
        <button type="submit" class="btn-primary text-sm">Actualizar Estado</button>
    </form>
</div>

<script>
    // Mostrar/ocultar motivo de rechazo
    document.querySelector('select[name="estado_postulacion"]').addEventListener('change', function() {
        const motivo = document.getElementById('motivoRechazo');
        if (this.value === 'rechazado') {
            motivo.classList.remove('hidden');
        } else {
            motivo.classList.add('hidden');
        }
    });
</script>

            <!-- Barra de progreso -->
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 mb-4">
                @php $pct = $totalRequisitos > 0 ? ($requisitosCompletos / $totalRequisitos) * 100 : 0; @endphp
                <div class="h-2 rounded-full {{ $pct >= 100 ? 'bg-green-500' : 'bg-yellow-500' }}" 
                     style="width: {{ $pct }}%"></div>
            </div>

            @if(count($requisitosEstado) > 0)
                <ul class="space-y-2">
                    @foreach($requisitosEstado as $item)
                    <li class="flex items-start gap-3 p-3 rounded-lg {{ $item['presentado'] ? 'bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-dark-bg border border-gray-100 dark:border-dark-border' }}">
                        @if($item['docente_requisito_id'])
                            <form action="{{ route('admin.docentes.toggleRequisito', [$docente, $item['docente_requisito_id']]) }}" method="POST" class="flex-shrink-0 mt-0.5">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-5 h-5 rounded-full {{ $item['presentado'] ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} flex items-center justify-center hover:opacity-80 transition-opacity">
                                    @if($item['presentado'])
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.docentes.storeRequisito', $docente) }}" method="POST" class="flex-shrink-0 mt-0.5">
                                @csrf
                                <input type="hidden" name="requisito_id" value="{{ $item['requisito']->id }}">
                                <button type="submit" class="w-5 h-5 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center hover:bg-green-500 transition-colors">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm {{ $item['presentado'] ? 'text-gray-900 dark:text-white font-medium' : 'text-gray-600 dark:text-gray-400' }}">
                                {{ $item['requisito']->descripcion }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs {{ $item['requisito']->obligatorio ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-400' }}">
                                    {{ $item['requisito']->obligatorio ? 'Obligatorio' : 'Opcional' }}
                                </span>
                                @if($item['presentado'] && $item['fecha'])
                                    <span class="text-xs text-gray-400">· {{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-400 text-center py-4">No hay requisitos definidos para docentes.</p>
            @endif
        </div>
        </div>

        <!-- Columna 2-3: Grupos y Horario -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Grupos Asignados -->
            <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-dark-border">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Grupos Asignados ({{ $docente->grupos->count() }}/4)
                    </h3>
                </div>
                <div class="p-6">
                    @if($docente->grupos->count() > 0)
                        <!-- Barra de carga -->
                        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 mb-4">
                            @php $cargaPct = $docente->grupos->count() / 4 * 100; @endphp
                            <div class="h-2 rounded-full {{ $cargaPct >= 100 ? 'bg-red-500' : ($cargaPct >= 75 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                 style="width: {{ $cargaPct }}%"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($docente->grupos as $grupo)
                            <a href="{{ route('admin.grupos.show', $grupo) }}" class="block p-4 bg-gray-50 dark:bg-dark-bg rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-mono font-bold text-blue-600 dark:text-blue-400 text-lg">{{ $grupo->codigo }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $grupo->turno === 'M' ? 'bg-yellow-100 text-yellow-700' : ($grupo->turno === 'T' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                                        {{ $grupo->turno === 'M' ? 'Mañana' : ($grupo->turno === 'T' ? 'Tarde' : 'Noche') }}
                                    </span>
                                </div>
                                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex justify-between">
                                        <span>Horario</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($grupo->horario_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($grupo->horario_fin)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Estudiantes</span>
                                        <span class="font-medium {{ $grupo->estudiantes_inscritos >= $grupo->capacidad_maxima ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $grupo->estudiantes_inscritos }}/{{ $grupo->capacidad_maxima }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-8">Sin grupos asignados.</p>
                    @endif
                </div>
            </div>

            <!-- Horario Semanal -->
            @if($docente->grupos->count() > 0)
            <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horario Semanal
                </h3>
                @php $turnos = $docente->grupos->pluck('turno')->unique(); @endphp
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="p-4 rounded-xl {{ $turnos->contains('M') ? 'bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800' : 'bg-gray-50 dark:bg-dark-bg border border-gray-100 dark:border-dark-border' }}">
                        <p class="text-2xl mb-1">🌅</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Mañana</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $turnos->contains('M') ? $docente->grupos->where('turno', 'M')->count() . ' grupo(s)' : 'No disponible' }}</p>
                    </div>
                    <div class="p-4 rounded-xl {{ $turnos->contains('T') ? 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800' : 'bg-gray-50 dark:bg-dark-bg border border-gray-100 dark:border-dark-border' }}">
                        <p class="text-2xl mb-1">☀️</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Tarde</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $turnos->contains('T') ? $docente->grupos->where('turno', 'T')->count() . ' grupo(s)' : 'No disponible' }}</p>
                    </div>
                    <div class="p-4 rounded-xl {{ $turnos->contains('N') ? 'bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800' : 'bg-gray-50 dark:bg-dark-bg border border-gray-100 dark:border-dark-border' }}">
                        <p class="text-2xl mb-1">🌙</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Noche</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $turnos->contains('N') ? $docente->grupos->where('turno', 'N')->count() . ' grupo(s)' : 'No disponible' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection