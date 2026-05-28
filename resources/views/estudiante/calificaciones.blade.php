@extends('layouts.estudiante')

@section('title', 'Calificaciones')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    @php $e = auth()->user()->estudiante; @endphp

    {{-- Header --}}
    <div>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Mis Calificaciones</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            {{ $e->calificaciones->count() }} materias evaluadas · 3 exámenes por materia · Mínimo 60 pts
        </p>
    </div>

    @if($e->calificaciones->count() > 0)
        {{-- Resumen general --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Promedio General</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $e->materiasAprobadas() }}/4 materias aprobadas</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-bold {{ $e->promedio() >= 60 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($e->promedio(), 1) }}
                    </span>
                    <p class="text-[10px] text-gray-400">pts</p>
                </div>
            </div>
            {{-- Barra de progreso --}}
            <div class="mt-3 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700 {{ $e->promedio() >= 60 ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gradient-to-r from-red-400 to-rose-500' }}" 
                     style="width: {{ min($e->promedio(), 100) }}%"></div>
            </div>
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>0</span>
                <span class="{{ $e->promedio() >= 60 ? 'text-green-500 font-medium' : '' }}">60 (mínimo)</span>
                <span>100</span>
            </div>
        </div>

        {{-- Grid de materias --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($e->calificaciones as $cal)
                <div class="bg-white dark:bg-gray-900 border rounded-2xl overflow-hidden transition-all hover:shadow-md
                    {{ $cal->estado === 'aprobado' ? 'border-green-200' : 'border-red-200' }}">
                    {{-- Header de materia --}}
                    <div class="px-5 py-3 border-b {{ $cal->estado === 'aprobado' ? 'bg-green-50/50 dark:bg-green-950/10 border-green-100 dark:border-green-900/30' : 'bg-red-50/50 dark:bg-red-950/10 border-red-100 dark:border-red-900/30' }}">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $cal->materia->nombre ?? 'Materia' }}</h3>
                            <x-badge :color="$cal->estado === 'aprobado' ? 'green' : 'red'">
                                {{ $cal->estado === 'aprobado' ? 'Aprobado' : 'Reprobado' }}
                            </x-badge>
                        </div>
                    </div>
                    {{-- Notas --}}
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                                <p class="text-[10px] text-gray-400 uppercase mb-1">Examen 1</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($cal->nota1, 1) }}</p>
                            </div>
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                                <p class="text-[10px] text-gray-400 uppercase mb-1">Examen 2</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($cal->nota2, 1) }}</p>
                            </div>
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                                <p class="text-[10px] text-gray-400 uppercase mb-1">Examen 3</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($cal->nota3, 1) }}</p>
                            </div>
                        </div>
                        {{-- Promedio materia --}}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
                            <span class="text-xs text-gray-500">Promedio</span>
                            <span class="text-xl font-bold {{ $cal->estado === 'aprobado' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $cal->promedio_formateado }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Estado final --}}
        @if($e->aproboCUP())
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 border border-green-200 dark:border-green-800 rounded-2xl p-6 text-center">
                <div class="w-14 h-14 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-green-700 dark:text-green-300">¡Felicitaciones! Aprobaste el CUP</h3>
                <p class="text-sm text-green-600 dark:text-green-400 mt-1">Has aprobado las 4 materias. Promedio final: {{ number_format($e->promedio(), 1) }} pts</p>
            </div>
        @elseif($e->materiasReprobadas() > 0)
            <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-6 text-center">
                <div class="w-14 h-14 mx-auto bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-amber-700 dark:text-amber-300">Atención: {{ $e->materiasReprobadas() }} materia(s) reprobada(s)</h3>
                <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">Necesitas aprobar todas las materias con nota ≥ 60</p>
            </div>
        @endif

    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Aún no hay calificaciones</h3>
            <p class="text-sm text-gray-500">Tus calificaciones aparecerán aquí cuando estés inscrito y rindas los exámenes.</p>
        </div>
    @endif
</div>
@endsection