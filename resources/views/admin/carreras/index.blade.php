@extends('layouts.admin')
@section('title', 'Carreras')
@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div><h1 class="text-xl font-bold text-gray-900 dark:text-white">Carreras</h1><p class="text-xs text-gray-500 dark:text-gray-400">{{ $carreras->total() }} carreras</p></div>
        <x-btn-primary :route="route('admin.carreras.create')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Nueva</x-btn-primary>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700"><x-th>Código</x-th><x-th>Nombre</x-th><x-th>Título</x-th><x-th class="text-center">Cupos</x-th><x-th class="text-center">Inscritos</x-th><x-th class="text-center">Estado</x-th><x-th class="text-center w-12"></x-th></tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($carreras as $c)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td class="font-mono font-semibold text-xs">{{ $c->codigo }}</x-td>
                        <x-td class="font-medium text-xs">{{ $c->nombre }}</x-td>
                        <x-td class="text-xs text-gray-500">{{ $c->titulo_otorgado }}</x-td>
                        <x-td class="text-center text-xs">{{ $c->cupos }}</x-td>
                        <x-td class="text-center text-xs">{{ $c->estudiantes_count }}</x-td>
                        <x-td class="text-center"><x-badge :color="$c->estado ? 'green' : 'gray'">{{ $c->estado ? 'Activo' : 'Inactivo' }}</x-badge></x-td>
                        <x-td class="text-center">
                            <div class="flex justify-center gap-0.5">
                                <x-btn-icon :route="route('admin.carreras.edit', $c)" title="Editar" color="blue"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></x-btn-icon>
                            </div>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay carreras registradas" :cols="7" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($carreras->hasPages())<div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">{{ $carreras->links() }}</div>@endif
    </div>
</div>
@endsection