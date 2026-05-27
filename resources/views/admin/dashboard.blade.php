@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="animate-fade-in space-y-8">
    <!-- Saludo y fecha -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Panel de Control</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">CUP FICCT · Gestión I/2025</h1>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ now()->format('d/m/Y H:i') }}</span>
            </div>
            <a href="{{ route('admin.estudiantes.create') }}" class="btn-primary inline-flex items-center gap-1.5 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Estudiante
            </a>
        </div>
    </div>
    <!-- Métricas Principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Estudiantes -->
        <div class="group relative bg-white dark:bg-dark-surface rounded-2xl border border-gray-100 dark:border-dark-border p-6 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estudiantes</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['estudiantes'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            
        </div>

        <!-- Docentes -->
        <div class="group relative bg-white dark:bg-dark-surface rounded-2xl border border-gray-100 dark:border-dark-border p-6 hover:shadow-lg hover:border-purple-200 dark:hover:border-purple-800 transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-purple-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Docentes</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['docentes'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Grupos -->
        <div class="group relative bg-white dark:bg-dark-surface rounded-2xl border border-gray-100 dark:border-dark-border p-6 hover:shadow-lg hover:border-green-200 dark:hover:border-green-800 transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-green-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Grupos activos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['grupos'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 dark:border-dark-border">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-green-600 dark:text-green-400">{{ $stats['grupos_disponibles'] }}</span> con cupo disponible
                </span>
            </div>
        </div>

        <!-- Materias -->
        <div class="group relative bg-white dark:bg-dark-surface rounded-2xl border border-gray-100 dark:border-dark-border p-6 hover:shadow-lg hover:border-orange-200 dark:hover:border-orange-800 transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-orange-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Materias CUP</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['materias'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Inscripciones + Enlaces rápidos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Últimas Inscripciones (ocupa 2 columnas) -->
        <div class="lg:col-span-2 bg-white dark:bg-dark-surface rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 dark:border-dark-border">
                <h2 class="font-semibold text-gray-900 dark:text-white">Últimas inscripciones</h2>
                <a href="{{ route('admin.inscripciones.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    Ver todas →
                </a>
            </div>
            <div class="overflow-x-auto">
                @if($ultimasInscripciones->count() > 0)
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-50 dark:divide-dark-border">
                            @foreach($ultimasInscripciones as $inscripcion)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 flex items-center justify-center text-xs font-bold text-blue-700 dark:text-blue-200">
                                            {{ strtoupper(substr($inscripcion->estudiante->nombre ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $inscripcion->estudiante->apellidos ?? 'N/A' }} {{ $inscripcion->estudiante->nombre ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $inscripcion->estudiante->ci ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold font-mono bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $inscripcion->grupo->codigo ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $inscripcion->estado === 'confirmado' ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 
                                           ($inscripcion->estado === 'pendiente' ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 
                                           'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300') }}">
                                        {{ ucfirst($inscripcion->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm">No hay inscripciones aún.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Accesos rápidos (1 columna) -->
        <div class="space-y-3">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-1">Accesos rápidos</h2>
            <a href="{{ route('admin.estudiantes.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md hover:border-blue-200 dark:hover:border-blue-800 transition-all">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Estudiantes</span>
            </a>
            <a href="{{ route('admin.grupos.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md hover:border-green-200 dark:hover:border-green-800 transition-all">
                <div class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Grupos</span>
            </a>
            <a href="{{ route('admin.calificaciones.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md hover:border-purple-200 dark:hover:border-purple-800 transition-all">
                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Calificaciones</span>
            </a>
            <a href="{{ route('admin.docentes.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md hover:border-orange-200 dark:hover:border-orange-800 transition-all">
                <div class="w-9 h-9 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Docentes</span>
            </a>
            <a href="{{ route('admin.reportes.postulantes') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border hover:shadow-md hover:border-red-200 dark:hover:border-red-800 transition-all">
                <div class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Reportes</span>
            </a>
        </div>
    </div>
</div>
@endsection