@extends('layouts.admin')

@section('title', 'Postulantes Docentes')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Postulantes Docentes</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $docentes->total() }} docentes en revisión</p>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-3 gap-3">
        <x-stat-card title="Pendientes" :value="$docentes->where('estado_postulacion', 'pendiente')->count()" color="yellow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="En Revisión" :value="$docentes->where('estado_postulacion', 'en_revision')->count()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </x-stat-card>
        <x-stat-card title="Aprobados" :value="$docentes->where('estado_postulacion', 'aprobado')->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Docente</x-th>
                        <x-th>CI</x-th>
                        <x-th>Especialidad</x-th>
                        <x-th class="text-center">Requisitos</x-th>
                        <x-th class="text-center">Estado</x-th>
                        <x-th class="text-center w-12"></x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($docentes as $d)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td class="font-medium">{{ $d->apellidos }}, {{ substr($d->nombre, 0, 1) }}.</x-td>
                        <x-td class="font-mono text-xs">{{ $d->ci }}</x-td>
                        <x-td class="text-xs">{{ $d->especialidad ?? '—' }}</x-td>
                        <x-td class="text-center">
                            <x-badge :color="$d->requisitos_presentados >= $d->requisitos_cumplidos && $d->requisitos_cumplidos > 0 ? 'green' : 'yellow'">
                                {{ $d->requisitos_presentados }}/{{ $d->requisitos_cumplidos }}
                            </x-badge>
                        </x-td>
                        <x-td class="text-center">
                            <x-badge :color="match($d->estado_postulacion){'aprobado'=>'green','rechazado'=>'red','en_revision'=>'blue',default=>'yellow'}">
                                {{ ucfirst(str_replace('_', ' ', $d->estado_postulacion)) }}
                            </x-badge>
                        </x-td>
                        <x-td class="text-center">
                            <x-btn-icon :route="route('admin.docentes.show', $d)" title="Revisar" color="blue">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </x-btn-icon>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay docentes postulantes" :cols="6" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($docentes->hasPages())
        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">{{ $docentes->links() }}</div>
        @endif
    </div>
</div>
@endsection