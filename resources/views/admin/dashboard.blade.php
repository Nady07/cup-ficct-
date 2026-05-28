@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Panel de Control</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('d/m/Y H:i') }} · CUP FICCT I/2025</p>
        </div>
        <x-btn-primary :route="route('admin.estudiantes.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Estudiante
        </x-btn-primary>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 auto-rows-fr">
        <x-stat-card title="Inscritos" :value="$stats['total_inscritos']" color="blue">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Aprobados" :value="$stats['total_aprobados']" color="green" :subtitle="$stats['porcentaje_aprobados'].'%'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Grupos" :value="$stats['total_grupos']" color="indigo" :subtitle="$stats['grupos_disponibles'].' libres'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </x-stat-card>
        <x-stat-card title="Promedio" :value="$stats['promedio_general']" color="purple">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </x-stat-card>
    </div>

    {{-- Últimas inscripciones --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Últimas inscripciones</h2>
            <a href="{{ route('admin.inscripciones.index') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Ver todas →</a>
        </div>
        @if($ultimasInscripciones->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($ultimasInscripciones as $i)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <x-td>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $i->estudiante->nombreCompleto() ?? 'N/A' }}</span>
                            </x-td>
                            <x-td>
                                <span class="text-gray-500">{{ $i->grupo->codigo ?? '—' }}</span>
                            </x-td>
                            <x-td class="text-right">
                                <x-badge :color="match($i->estado){'confirmado'=>'green','pendiente'=>'yellow','rechazado'=>'red','completado'=>'blue',default=>'gray'}">
                                    {{ ucfirst($i->estado) }}
                                </x-badge>
                            </x-td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state message="No hay inscripciones aún" :cols="3" />
        @endif
    </div>
</div>
@endsection