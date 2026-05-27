@extends('layouts.admin')

@section('title', 'Docentes')

@section('content')
<div class="animate-fade-in space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Docentes en Clases</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $docentes->total() }} docentes activos · CUP I/2025</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.docentes.postulantes') }}" class="btn-secondary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Ver Postulantes
            </a>
        </div>
    </div>

    <!-- KPIs de docentes activos -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    {{-- Docentes dando clases --}}
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Docentes</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $docentes->total() }}</p>
        </div>
    </div>

    {{-- Total de grupos abiertos --}}
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Grupos</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $docentes->sum('grupos_count') }}</p>
        </div>
    </div>

    {{-- Total estudiantes en clases --}}
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Estudiantes inscritos</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">
                {{ $docentes->sum(function($d) { return $d->grupos->sum('estudiantes_inscritos'); }) }}
            </p>
        </div>
    </div>

    {{-- Capacidad disponible --}}
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">estudiantes por grupo</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">
                @php
                    $capacidadTotal = $docentes->sum(function($d) { return $d->grupos->sum('capacidad_maxima'); });
                    $inscritos = $docentes->sum(function($d) { return $d->grupos->sum('estudiantes_inscritos'); });
                @endphp
                {{ $capacidadTotal - $inscritos }}
            </p>
        </div>
    </div>
</div>

    <!-- Tabla de docentes activos -->
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-dark-surface border-b border-gray-100 dark:border-dark-border">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Docente</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Especialidad</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Grupos</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Horarios</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estudiantes</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-dark-border">
                    @forelse($docentes as $docente)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface/50 transition-colors">
                        {{-- Docente --}}
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.docentes.show', $docente) }}" class="flex items-center gap-3 group">
                                <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-sm font-bold text-purple-600 dark:text-purple-400 flex-shrink-0">
                                    {{ strtoupper(substr($docente->nombre, 0, 1)) }}{{ strtoupper(substr($docente->apellidos, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                        {{ $docente->apellidos }}, {{ $docente->nombre }}
                                    </p>
                                    <p class="text-xs text-gray-400 font-mono">CI: {{ $docente->ci }}</p>
                                </div>
                            </a>
                        </td>
                        {{-- Especialidad --}}
                        <td class="px-5 py-3.5">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $docente->especialidad ?? '—' }}</span>
                        </td>
                        {{-- Grupos --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-300">
                                {{ $docente->grupos_count ?? 0 }}/4
                            </span>
                        </td>
                        {{-- Horarios --}}
                        <td class="px-5 py-3.5">
                            @if($docente->grupos && $docente->grupos->count() > 0)
                                <div class="space-y-1">
                                    @foreach($docente->grupos as $grupo)
                                    <div class="flex items-center gap-2 text-xs">
                                        <a href="{{ route('admin.grupos.show', $grupo) }}" class="font-mono font-bold text-blue-600 hover:underline">{{ $grupo->codigo }}</a>
                                        <span class="text-gray-400">{{ \Carbon\Carbon::parse($grupo->horario_inicio)->format('H:i') }}-{{ \Carbon\Carbon::parse($grupo->horario_fin)->format('H:i') }}</span>
                                        <span class="px-1.5 py-0.5 rounded text-xs {{ $grupo->turno === 'M' ? 'bg-yellow-100 text-yellow-700' : ($grupo->turno === 'T' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                                            {{ $grupo->turno }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Sin grupos</span>
                            @endif
                        </td>
                        {{-- Estudiantes --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-sm font-bold text-blue-600">
                                {{ $docente->grupos->sum('estudiantes_inscritos') }}
                            </span>
                        </td>
                        {{-- Acciones --}}
                        <td class="px-5 py-3.5 text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('admin.docentes.show', $docente) }}" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-20 text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gray-50 dark:bg-dark-bg flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-2">No hay docentes activos</h3>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">Aprueba postulantes para que empiecen a dar clases.</p>
                            <a href="{{ route('admin.docentes.postulantes') }}" class="btn-primary">Ver Postulantes</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($docentes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-border">{{ $docentes->links() }}</div>
        @endif
    </div>
</div>
@endsection