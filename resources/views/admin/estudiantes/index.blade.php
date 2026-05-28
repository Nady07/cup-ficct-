@extends('layouts.admin')

@section('title', 'Estudiantes')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Estudiantes</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $estudiantes->total() }} registros encontrados</p>
        </div>
        {{-- BOTÓN PARA VER POSTULANTES --}}
        <a href="{{ route('admin.estudiantes.postulantes') }}" class="btn-secondary text-xs px-3 py-1.5 inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Ver Postulantes ({{ \App\Models\Estudiante::whereIn('estado_flujo', ['postulante', 'requisitos_aprobados'])->count() }})
        </a>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <x-stat-card title="Total" :value="$estudiantes->total()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Pago Confirmado" :value="$estudiantes->where('estado_flujo', 'pago_confirmado')->count()" color="yellow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Inscritos" :value="$estudiantes->whereIn('estado_flujo', ['inscrito', 'cup_aprobado'])->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="CUP Aprobado" :value="$estudiantes->filter(fn($e) => $e->aproboCUP())->count()" color="purple">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </x-stat-card>
    </div>

    {{-- Filtros inteligentes --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-3" x-data>
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <x-search-input placeholder="Nombre, apellido o CI..." :value="request('buscar')" />
            <x-select-filter name="carrera_id" :selected="request('carrera_id')" placeholder="Todas las carreras" :options="$carreras->pluck('nombre', 'id')->toArray()" />
           
            <a href="{{ route('admin.estudiantes.index') }}" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1.5" title="Limpiar filtros">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </form>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Estudiante</x-th>
                        <x-th>CI</x-th>
                        <x-th class="hidden md:table-cell">Carrera</x-th>
                        <x-th class="hidden lg:table-cell">Grupo</x-th>
                        <x-th class="text-center">Flujo</x-th>
                        <x-th class="text-center w-14">Prom</x-th>
                        <x-th class="text-center w-12"></x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($estudiantes as $e)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        {{-- Estudiante --}}
                        <x-td>
                            <a href="{{ route('admin.estudiantes.show', $e) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600 truncate block max-w-[180px]">
                                {{ $e->apellidos }}, {{ substr($e->nombre, 0, 1) }}.
                            </a>
                        </x-td>
                        
                        {{-- CI --}}
                        <x-td>
                            <span class="font-mono text-gray-500">{{ $e->ci }}</span>
                        </x-td>
                        
                        {{-- Carrera --}}
                        <x-td class="hidden md:table-cell text-gray-500">
                            {{ $e->carreraInteres->codigo ?? '—' }}
                        </x-td>
                        
                        {{-- Grupo --}}
                        <x-td class="hidden lg:table-cell">
                            <span class="font-mono text-gray-500">{{ $e->inscripcion->grupo->codigo ?? '—' }}</span>
                        </x-td>
                        
                        {{-- Estado del flujo --}}
                        <x-td class="text-center">
                            @switch($e->estado_flujo)
                                @case('postulante')
                                    <x-badge color="gray">📝 Postulante</x-badge>
                                    @break
                                @case('requisitos_aprobados')
                                    <x-badge color="blue">💰 Pendiente pago</x-badge>
                                    @break
                                @case('pago_confirmado')
                                    <x-badge color="yellow">✅ Pago confirmado</x-badge>
                                    @break
                                @case('inscrito')
                                    <x-badge color="green">📚 Inscrito</x-badge>
                                    @break
                                @case('cup_aprobado')
                                    <x-badge color="green">🎓 CUP Aprobado</x-badge>
                                    @break
                                @default
                                    <x-badge color="gray">—</x-badge>
                            @endswitch
                        </x-td>
                        
                        {{-- Promedio --}}
                        <x-td class="text-center font-semibold {{ $e->promedio() >= 60 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($e->promedio(), 1) }}
                        </x-td>
                        
                        {{-- Acciones --}}
                        <x-td class="text-center">
                            <div class="flex justify-center gap-0.5">
                                <x-btn-icon :route="route('admin.estudiantes.show', $e)" title="Ver" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </x-btn-icon>
                                <x-btn-icon :route="route('admin.estudiantes.edit', $e)" title="Editar" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </x-btn-icon>
                            </div>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No se encontraron estudiantes" :cols="7" />
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