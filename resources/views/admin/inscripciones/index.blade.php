@extends('layouts.admin')

@section('title', 'Inscripciones')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Inscripciones</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $inscripciones->total() }} inscripciones registradas</p>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <x-stat-card title="Total" :value="$inscripciones->total()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </x-stat-card>
        <x-stat-card title="Confirmadas" :value="$inscripciones->where('estado', 'confirmado')->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Pendientes" :value="$inscripciones->where('estado', 'pendiente')->count()" color="yellow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Rechazadas" :value="$inscripciones->where('estado', 'rechazado')->count()" color="red">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <x-th>Estudiante</x-th>
                        <x-th>CI</x-th>
                        <x-th>Grupo</x-th>
                        <x-th class="text-center">Monto</x-th>
                        <x-th class="text-center">Estado</x-th>
                        <x-th class="text-center w-28">Cambiar Estado</x-th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($inscripciones as $i)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <x-td>
                            <a href="{{ route('admin.estudiantes.show', $i->estudiante) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600">
                                {{ $i->estudiante->apellidos ?? '—' }}, {{ substr($i->estudiante->nombre ?? '', 0, 1) }}.
                            </a>
                        </x-td>
                        <x-td>
                            <span class="font-mono text-gray-500 text-xs">{{ $i->estudiante->ci ?? '—' }}</span>
                        </x-td>
                        <x-td>
                            <span class="font-mono font-semibold text-xs">{{ $i->grupo->codigo ?? '—' }}</span>
                        </x-td>
                        <x-td class="text-center text-xs">
                            Bs. {{ number_format($i->monto_pagado ?? 0, 2) }}
                        </x-td>
                        <x-td class="text-center">
                            <x-badge :color="match($i->estado){'confirmado'=>'green','pendiente'=>'yellow','rechazado'=>'red','completado'=>'blue',default=>'gray'}">
                                {{ ucfirst($i->estado) }}
                            </x-badge>
                        </x-td>
                        <x-td class="text-center">
                            <form action="{{ route('admin.inscripciones.updateEstado', $i) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <select name="estado" onchange="this.form.submit()" 
                                        class="text-[10px] border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-1.5 py-1">
                                    <option value="pendiente" {{ $i->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $i->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="rechazado" {{ $i->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="completado" {{ $i->estado === 'completado' ? 'selected' : '' }}>Completado</option>
                                </select>
                            </form>
                        </x-td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay inscripciones registradas" :cols="6" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inscripciones->hasPages())
        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-800 text-xs">
            {{ $inscripciones->links() }}
        </div>
        @endif
    </div>
</div>
@endsection