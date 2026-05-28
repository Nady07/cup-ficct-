@extends('layouts.estudiante')

@section('title', 'Horario')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    @php 
        $e = auth()->user()->estudiante;
        $flujo = $e->estado_flujo ?? 'postulante';
    @endphp

    {{-- Header --}}
    <div>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Mi Horario</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Grupo, materias y horario de clases</p>
    </div>

    {{-- Solo visible si está inscrito --}}
    @if(in_array($flujo, ['inscrito', 'cup_aprobado']) && $e->inscripcion)
        @php $grupo = $e->inscripcion->grupo; @endphp
        
        {{-- Datos del grupo --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Mi Grupo</h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-slate-50 dark:bg-slate-900/30 rounded-xl p-4 text-center border border-slate-200 dark:border-slate-800">
                        <svg class="w-5 h-5 mx-auto text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        <p class="text-[10px] text-gray-400 uppercase">Código</p>
                        <p class="text-lg font-mono font-bold text-gray-900 dark:text-white">{{ $grupo->codigo ?? '—' }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900/30 rounded-xl p-4 text-center border border-slate-200 dark:border-slate-800">
                        <svg class="w-5 h-5 mx-auto text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[10px] text-gray-400 uppercase">Horario</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $grupo->horario_inicio ?? '—' }} - {{ $grupo->horario_fin ?? '—' }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900/30 rounded-xl p-4 text-center border border-slate-200 dark:border-slate-800">
                        <svg class="w-5 h-5 mx-auto text-amber-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <p class="text-[10px] text-gray-400 uppercase">Turno</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $grupo->turno === 'M' ? 'Mañana' : ($grupo->turno === 'T' ? 'Tarde' : 'Noche') }}
                        </p>
                    </div>
                </div>
                
                {{-- Docente --}}
                @if($grupo->docente)
                <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 rounded-xl border border-blue-100 dark:border-blue-900/30">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-sm font-bold text-blue-600 shadow-sm">
                            {{ strtoupper(substr($grupo->docente->nombre ?? 'D', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $grupo->docente->apellidos ?? '' }} {{ $grupo->docente->nombre ?? '' }}</p>
                            <p class="text-xs text-gray-500">{{ $grupo->docente->especialidad ?? 'Docente CUP' }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $grupo->docente->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Las 4 materias --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Materias del CUP</h3>
                <p class="text-[10px] text-gray-400 mt-0.5">4 materias obligatorias · 3 exámenes por materia · Mínimo 60 pts</p>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(\App\Models\MateriaCup::where('estado', true)->orderBy('orden')->get() as $materia)
                        @php $cal = $e->calificaciones->where('materia_id', $materia->id)->first(); @endphp
                        <div class="p-4 rounded-xl border transition-all hover:shadow-md
                            {{ $cal ? ($cal->estado === 'aprobado' ? 'border-green-200 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20' : 'border-red-200 bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-950/20 dark:to-rose-950/20') : 'border-gray-200 bg-slate-50 dark:bg-slate-900/30 dark:border-slate-800' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $materia->nombre }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $materia->codigo }} · {{ $materia->valor_puntaje }} pts</p>
                                </div>
                                @if($cal)
                                    <div class="text-right">
                                        <span class="text-lg font-bold {{ $cal->estado === 'aprobado' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $cal->promedio_formateado }}
                                        </span>
                                        <p class="text-[10px] {{ $cal->estado === 'aprobado' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $cal->estado === 'aprobado' ? 'Aprobado' : 'Reprobado' }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Sin notas</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($flujo === 'pago_confirmado')
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-amber-50 dark:bg-amber-950/20 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pronto se te asignará un grupo</h3>
            <p class="text-sm text-gray-500">Tu pago ha sido confirmado. El administrador te asignará un grupo y horario pronto.</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Completa tu postulación</h3>
            <p class="text-sm text-gray-500">Debes completar los requisitos y el pago para que se te asigne un grupo y horario.</p>
        </div>
    @endif
</div>
@endsection