@extends('layouts.admin')

@section('title', 'Materias')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Materias</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $materias->total() }} materias · Mínimo {{ \App\Models\Calificacion::NOTA_MINIMA_APROBACION }} pts</p>
        </div>
        <x-btn-primary :route="route('admin.materias.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva
        </x-btn-primary>
    </div>

    {{-- Grid de Materias --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @forelse($materias as $m)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4 {{ !$m->estado ? 'opacity-60' : '' }}">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $m->nombre }}</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $m->codigo }} · {{ $m->valor_puntaje }} pts</p>
                    </div>
                </div>
                <x-badge :color="$m->estado ? 'green' : 'gray'">
                    {{ $m->estado ? 'Activo' : 'Inactivo' }}
                </x-badge>
            </div>

            {{-- Métricas compactas --}}
            <div class="grid grid-cols-3 gap-2 mb-3">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded p-2 text-center">
                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Orden</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $m->orden }}°</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded p-2 text-center">
                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Nota Mín.</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">≥ {{ $m->nota_minima }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded p-2 text-center">
                    <p class="text-[10px] text-blue-500 dark:text-blue-400">Puntaje</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $m->valor_puntaje }}</p>
                </div>
            </div>

            {{-- Descripción --}}
            @if($m->descripcion)
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mb-3 line-clamp-1">{{ $m->descripcion }}</p>
            @endif

            {{-- Acciones --}}
            <div class="flex justify-end gap-1 pt-3 border-t border-gray-100 dark:border-gray-800">
                <x-btn-icon :route="route('admin.materias.edit', $m)" title="Editar" color="blue">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </x-btn-icon>
                <form action="{{ route('admin.materias.destroy', $m) }}" method="POST" onsubmit="return confirm('¿Eliminar esta materia?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 rounded transition-colors" title="Eliminar">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-2">
            <x-empty-state message="No hay materias registradas" submessage="Cree la primera materia del CUP" :cols="1" />
        </div>
        @endforelse
    </div>

    @if($materias->hasPages())
    <div class="text-xs">{{ $materias->links() }}</div>
    @endif
</div>
@endsection