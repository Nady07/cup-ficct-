@extends('layouts.admin')

@section('title', 'Estadísticas por Materia')

@section('content')
<div class="animate-fade-in space-y-6">
    <h1 class="text-2xl font-bold">📊 Estadísticas por Materia</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($materias as $materia)
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-6">
            <h3 class="text-lg font-bold mb-4">{{ $materia->nombre }} ({{ $materia->codigo }})</h3>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 dark:bg-dark-bg rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500">Evaluados</p>
                    <p class="text-xl font-bold">{{ $materia->total_evaluados }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 text-center">
                    <p class="text-xs text-green-600">Aprobados</p>
                    <p class="text-xl font-bold text-green-600">{{ $materia->total_aprobados }}</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 text-center">
                    <p class="text-xs text-red-600">Reprobados</p>
                    <p class="text-xl font-bold text-red-600">{{ $materia->total_reprobados }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-center">
                    <p class="text-xs text-blue-600">% Aprobación</p>
                    <p class="text-xl font-bold text-blue-600">
                        {{ $materia->total_evaluados > 0 ? round(($materia->total_aprobados / $materia->total_evaluados) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Promedio general</span>
                    <span class="font-bold">{{ number_format($materia->promedio_notas, 1) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nota más alta</span>
                    <span class="font-bold text-green-600">{{ number_format($materia->nota_mas_alta, 1) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nota más baja</span>
                    <span class="font-bold text-red-600">{{ number_format($materia->nota_mas_baja, 1) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection