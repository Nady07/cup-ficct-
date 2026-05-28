@extends('layouts.admin')

@section('title', 'Grupos')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Grupos</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $grupos->total() }} grupos</p>
        </div>
        <x-btn-primary :route="route('admin.grupos.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo
        </x-btn-primary>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Código</x-th>
                        <x-th>Turno</x-th>
                        <x-th>Horario</x-th>
                        <x-th>Docente</x-th>
                        <x-th class="text-center">Cupos</x-th>
                        <x-th class="text-center w-12"></x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($grupos as $g)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td class="font-mono font-semibold">{{ $g->codigo }}</x-td>
                        <x-td>
                            <x-badge :color="$g->turno === 'M' ? 'blue' : ($g->turno === 'T' ? 'yellow' : 'purple')">
                                {{ $g->turno === 'M' ? 'Mañana' : ($g->turno === 'T' ? 'Tarde' : 'Noche') }}
                            </x-badge>
                        </x-td>
                        <x-td class="text-xs">{{ $g->horario_inicio }} - {{ $g->horario_fin }}</x-td>
                        <x-td class="text-xs">{{ $g->docente->apellidos ?? 'Sin asignar' }}</x-td>
                        <x-td class="text-center text-xs">{{ $g->inscripciones_count ?? 0 }}/{{ $g->capacidad_maxima }}</x-td>
                        <x-td class="text-center">
                            <div class="flex justify-center gap-0.5">
                                <x-btn-icon :route="route('admin.grupos.show', $g)" title="Ver" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </x-btn-icon>
                                <x-btn-icon :route="route('admin.grupos.edit', $g)" title="Editar" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </x-btn-icon>
                            </div>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay grupos registrados" :cols="6" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($grupos->hasPages())
        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">{{ $grupos->links() }}</div>
        @endif
    </div>
</div>
@endsection