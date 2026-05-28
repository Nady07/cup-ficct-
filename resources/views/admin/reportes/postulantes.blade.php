@extends('layouts.admin')

@section('title', 'Lista de Postulantes')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Lista de Postulantes</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $estudiantes->total() }} postulantes registrados</p>
        </div>
        {{-- Botones de exportación --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.reportes.postulantes.pdf') }}" class="btn-secondary text-xs px-3 py-1.5 inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
            </a>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <x-stat-card title="Total" :value="$estudiantes->total()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Inscritos" :value="$estudiantes->filter(fn($e) => $e->inscripcion)->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Pendientes" :value="$estudiantes->filter(fn($e) => !$e->inscripcion || $e->inscripcion->estado === 'pendiente')->count()" color="yellow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Con Grupo" :value="$estudiantes->filter(fn($e) => $e->inscripcion && $e->inscripcion->grupo_id)->count()" color="purple">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </x-stat-card>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>#</x-th>
                        <x-th>Postulante</x-th>
                        <x-th>CI</x-th>
                        <x-th class="hidden md:table-cell">Carrera</x-th>
                        <x-th class="hidden lg:table-cell">Grupo</x-th>
                        <x-th class="text-center">Estado</x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($estudiantes as $index => $e)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td class="text-gray-400 text-xs w-8">
                            {{ $estudiantes->firstItem() + $index }}
                        </x-td>
                        <x-td>
                            <a href="{{ route('admin.estudiantes.show', $e) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600 truncate block max-w-[180px]">
                                {{ $e->apellidos }}, {{ substr($e->nombre, 0, 1) }}.
                            </a>
                        </x-td>
                        <x-td>
                            <span class="font-mono text-gray-500 text-xs">{{ $e->ci }}</span>
                        </x-td>
                        <x-td class="hidden md:table-cell text-gray-500 text-xs">
                            {{ $e->carreraInteres->codigo ?? '—' }}
                        </x-td>
                        <x-td class="hidden lg:table-cell">
                            <span class="font-mono text-xs text-gray-500">{{ $e->inscripcion->grupo->codigo ?? '—' }}</span>
                        </x-td>
                        <x-td class="text-center">
                            @php $est = $e->inscripcion->estado ?? null; @endphp
                            <x-badge :color="match($est){'confirmado'=>'green','pendiente'=>'yellow','rechazado'=>'red',default=>'gray'}">
                                {{ $est ? ucfirst($est) : 'Sin inscripción' }}
                            </x-badge>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay postulantes registrados" :cols="6" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($estudiantes->hasPages())
        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">
            {{ $estudiantes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection