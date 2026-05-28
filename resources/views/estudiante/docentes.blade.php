@extends('layouts.estudiante')

@section('title', 'Docentes')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Mis Docentes</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Información de contacto de tu docente asignado</p>
    </div>

    @if($docente)
        {{-- Docente asignado --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden">
            {{-- Header con gradiente --}}
            <div class="bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 p-6 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center text-xl font-bold ring-2 ring-white/20">
                        {{ strtoupper(substr($docente->nombre ?? 'D', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight">{{ $docente->apellidos ?? '' }} {{ $docente->nombre ?? '' }}</h2>
                        <p class="text-slate-300 text-sm">{{ $docente->especialidad ?? 'Docente CUP' }}</p>
                    </div>
                </div>
            </div>

            {{-- Datos del docente --}}
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Email</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $docente->email ?? 'No disponible' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Teléfono</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $docente->telefono ?? 'No disponible' }}</p>
                        </div>
                    </div>
                    @if($docente->experiencia)
                    <div class="sm:col-span-2 flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-slate-200 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Experiencia</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $docente->experiencia }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información de contacto --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 border border-blue-200 dark:border-blue-900/30 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-sm font-semibold text-blue-700 dark:text-blue-300">Consultas Académicas</h4>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">Contacta a tu docente durante sus horas de oficina o por correo electrónico. El tiempo de respuesta es de 24-48 horas.</p>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-950/20 dark:to-yellow-950/20 border border-amber-200 dark:border-amber-900/30 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h4 class="text-sm font-semibold text-amber-700 dark:text-amber-300">Soporte Académico</h4>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400">La FICCT ofrece tutorías, biblioteca digital y grupos de estudio para apoyar tu aprendizaje.</p>
            </div>
        </div>

    @else
        {{-- Sin docente asignado --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No tienes docentes asignados</h3>
            <p class="text-sm text-gray-500">Completa tu inscripción para ver los docentes de tu grupo.</p>
        </div>
    @endif
</div>
@endsection