@extends('layouts.admin')

@section('title', 'Postulantes - Revisión de Requisitos')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <a href="{{ route('admin.estudiantes.index') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Volver a Estudiantes
            </a>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Postulantes</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $estudiantes->total() }} postulantes con requisitos enviados</p>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-3 gap-3">
        <x-stat-card title="Pendientes" :value="$estudiantes->where('estado_flujo', 'postulante')->count()" color="yellow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Requisitos OK" :value="$estudiantes->where('requisitos_completos', true)->count()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Aprobados" :value="$estudiantes->where('estado_flujo', 'requisitos_aprobados')->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </x-stat-card>
    </div>

    {{-- Filtros --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-3" x-data>
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <x-search-input placeholder="Nombre, apellido o CI..." :value="request('buscar')" />
            <x-select-filter name="carrera_id" :selected="request('carrera_id')" placeholder="Todas las carreras" :options="$carreras->pluck('nombre', 'id')->toArray()" />
             <!-- <x-select-filter name="estado_flujo" :selected="request('estado_flujo')" placeholder="Todos los flujos"
                :options="[
                    'postulante' => 'Postulante',
                    'requisitos_aprobados' => 'Requisitos aprobados',
                    'pago_confirmado' => 'Pago confirmado',
                    'inscrito' => 'Inscrito',
                    'cup_aprobado' => 'CUP Aprobado'
                ]" /> -->
            <a href="{{ route('admin.estudiantes.postulantes') }}" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1.5" title="Limpiar filtros">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </form>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Estudiante</x-th>
                        <x-th>CI</x-th>
                        <x-th class="hidden md:table-cell">Carrera</x-th>
                        <x-th class="text-center">Requisitos</x-th>
                        <x-th class="text-center">Estado</x-th>
                        <x-th class="text-center w-20">Acción</x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($estudiantes as $e)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td>
                            <a href="{{ route('admin.estudiantes.show', $e) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600">
                                {{ $e->apellidos }}, {{ substr($e->nombre, 0, 1) }}.
                            </a>
                        </x-td>
                        <x-td>
                            <span class="font-mono text-gray-500 text-xs">{{ $e->ci }}</span>
                        </x-td>
                        <x-td class="hidden md:table-cell text-gray-500 text-xs">
                            {{ $e->carreraInteres->codigo ?? '—' }}
                        </x-td>
                        <x-td class="text-center">
                            @if($e->requisitos_completos)
                                <x-badge color="green">✅ Completos</x-badge>
                            @else
                                <x-badge color="red">❌ Pendientes</x-badge>
                            @endif
                        </x-td>
                        <x-td class="text-center">
                            @if($e->estado_flujo === 'requisitos_aprobados')
                                <x-badge color="green">Aprobado</x-badge>
                            @else
                                <x-badge color="yellow">En revisión</x-badge>
                            @endif
                        </x-td>
                        <x-td class="text-center">
                            <div class="flex justify-center gap-1">
                                {{-- Botón Revisar --}}
                                <x-btn-icon :route="route('admin.estudiantes.show', $e)" title="Revisar" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </x-btn-icon>
                                
                                {{-- Aprobar requisitos rápido --}}
                                @if($e->requisitos_completos && $e->estado_flujo === 'postulante')
                                    <form action="{{ route('admin.estudiantes.aprobarRequisitos', $e) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="p-1 text-gray-400 hover:text-green-600 rounded transition-colors" title="Aprobar requisitos">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay postulantes pendientes" :cols="6" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($estudiantes->hasPages())
        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">
            {{ $estudiantes->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection