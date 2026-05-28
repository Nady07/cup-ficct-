@extends('layouts.admin')

@section('title', 'Docentes')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Docentes</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $docentes->total() }} docentes</p>
        </div>
        <x-btn-primary :route="route('admin.docentes.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo
        </x-btn-primary>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Docente</x-th>
                        <x-th>CI</x-th>
                        <x-th>Especialidad</x-th>
                        <x-th class="text-center">Grupos</x-th>
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
                        <x-td class="text-center text-xs">{{ $d->grupos_count }}</x-td>
                        <x-td class="text-center">
                            <x-badge :color="$d->estado ? 'green' : 'gray'">
                                {{ $d->estado ? 'Activo' : 'Inactivo' }}
                            </x-badge>
                        </x-td>
                        <x-td class="text-center">
                            <div class="flex justify-center gap-0.5">
                                <x-btn-icon :route="route('admin.docentes.show', $d)" title="Ver" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </x-btn-icon>
                                <x-btn-icon :route="route('admin.docentes.edit', $d)" title="Editar" color="blue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </x-btn-icon>
                            </div>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay docentes registrados" :cols="6" />
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