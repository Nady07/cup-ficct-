@extends('layouts.admin')

@section('title', 'Estadísticas por Materia')

@section('content')
<div class="space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Estadísticas por Materia</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $materias->count() }} materias evaluadas</p>
        </div>
        {{-- Botón de exportación --}}
        <a href="{{ route('admin.reportes.estadisticas_materias.pdf') }}" class="btn-secondary text-xs px-3 py-1.5 inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            PDF
        </a>
    </div>

    {{-- Grid de materias --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($materias as $m)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
            {{-- Nombre materia --}}
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $m->nombre }}</h3>
                <span class="text-[10px] font-mono text-gray-400">{{ $m->codigo }}</span>
            </div>
            
            {{-- KPIs en 2x2 --}}
            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded p-2 text-center">
                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Evaluados</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $m->total_evaluados }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-950/20 rounded p-2 text-center">
                    <p class="text-[10px] text-green-600 dark:text-green-400">Aprobados</p>
                    <p class="text-sm font-bold text-green-600 dark:text-green-400">{{ $m->total_aprobados }}</p>
                </div>
                <div class="bg-red-50 dark:bg-red-950/20 rounded p-2 text-center">
                    <p class="text-[10px] text-red-600 dark:text-red-400">Reprobados</p>
                    <p class="text-sm font-bold text-red-600 dark:text-red-400">{{ $m->total_reprobados }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-950/20 rounded p-2 text-center">
                    <p class="text-[10px] text-blue-600 dark:text-blue-400">% Aprob.</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                        {{ $m->total_evaluados > 0 ? round(($m->total_aprobados / $m->total_evaluados) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>

            {{-- Resumen --}}
            <div class="space-y-1.5 pt-3 border-t border-gray-100 dark:border-gray-800">
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">Promedio</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($m->promedio_notas, 1) }}</span>
                </div>
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">Más alta</span>
                    <span class="font-semibold text-green-600">{{ number_format($m->nota_mas_alta, 1) }}</span>
                </div>
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">Más baja</span>
                    <span class="font-semibold text-red-600">{{ number_format($m->nota_mas_baja, 1) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection