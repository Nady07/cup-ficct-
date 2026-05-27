@extends('layouts.admin')

@section('title', 'Cálculo de Grupos')

@section('content')
<div class="animate-fade-in space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.grupos.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1 mb-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a grupos
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">📊 Cálculo Automático de Grupos</h1>
        <p class="text-sm text-gray-500 mt-1">Fórmula: CEIL(Total Inscritos / 70)</p>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Total Inscritos</p>
            <p class="text-3xl font-bold text-blue-600">{{ $resumen['total_inscritos'] }}</p>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Grupos Actuales</p>
            <p class="text-3xl font-bold text-purple-600">{{ $resumen['grupos_actuales'] }}</p>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Grupos Necesarios</p>
            <p class="text-3xl font-bold {{ $resumen['faltan_grupos'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $resumen['grupos_necesarios'] }}
            </p>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Cupos Disponibles</p>
            <p class="text-3xl font-bold {{ $resumen['cupos_disponibles'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $resumen['cupos_disponibles'] }}
            </p>
        </div>
    </div>

    <!-- Alerta de Grupos Faltantes -->
    @if($resumen['faltan_grupos'] > 0)
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl p-4 flex items-start gap-3">
        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
        <div>
            <p class="font-semibold text-yellow-800 dark:text-yellow-200">⚠️ Faltan {{ $resumen['faltan_grupos'] }} grupo(s) para cubrir la demanda</p>
            <p class="text-sm text-yellow-600 dark:text-yellow-300 mt-1">Capacidad total actual: {{ $resumen['capacidad_total'] }} estudiantes. Se necesitan {{ $resumen['grupos_necesarios'] }} grupos.</p>
        </div>
    </div>
    @endif

    <!-- Fórmula -->
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
        <h3 class="text-lg font-semibold mb-3">🧮 Fórmula de Cálculo</h3>
        <div class="bg-gray-50 dark:bg-dark-bg rounded-lg p-4 font-mono text-sm">
            <p><span class="text-blue-600">Grupos Necesarios</span> = <span class="text-purple-600">CEIL</span>(<span class="text-green-600">{{ $resumen['total_inscritos'] }}</span> / <span class="text-orange-600">70</span>)</p>
            <p class="mt-2">= <span class="text-purple-600">CEIL</span>(<span class="text-green-600">{{ number_format($resumen['total_inscritos'] / 70, 2) }}</span>)</p>
            <p class="mt-2 text-lg font-bold">= <span class="text-blue-600">{{ $resumen['grupos_necesarios'] }}</span> grupos</p>
        </div>
    </div>

    <!-- Tabla de Grupos Actuales -->
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-dark-border">
            <h3 class="text-lg font-semibold">📋 Distribución Actual de Grupos</h3>
        </div>
        <div class="table-responsive">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-dark-surface">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Código</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Turno</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Docente</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Inscritos</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">% Ocupado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @foreach($grupos as $grupo)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface">
                        <td class="px-4 py-3 font-mono font-bold">{{ $grupo->codigo }}</td>
                        <td class="px-4 py-3">{{ $grupo->turno === 'M' ? '🌅 Mañana' : ($grupo->turno === 'T' ? '☀️ Tarde' : '🌙 Noche') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $grupo->docente->apellidos ?? 'Sin asignar' }}</td>
                        <td class="px-4 py-3 text-center font-medium">{{ $grupo->inscripciones_count }}/70</td>
                        <td class="px-4 py-3 text-center">
                            @php $pct = ($grupo->inscripciones_count / 70) * 100; @endphp
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                         style="width: {{ min($pct, 100) }}%"></div>
                                </div>
                                <span class="text-xs w-10">{{ number_format($pct, 0) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection