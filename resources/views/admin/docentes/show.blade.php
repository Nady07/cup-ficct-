@extends('layouts.admin')

@section('title', 'Perfil del Docente')

@section('content')
<div class="space-y-4">
    <a href="{{ route('admin.docentes.index') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver
    </a>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
        <h2 class="text-sm font-semibold mb-3">{{ $docente->apellidos }}, {{ $docente->nombre }}</h2>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800"><span class="text-gray-500">CI</span><span class="font-mono">{{ $docente->ci }}</span></div>
            <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800"><span class="text-gray-500">Email</span><span>{{ $docente->email }}</span></div>
            <div class="flex justify-between py-1.5 border-b border-gray-100 dark:border-gray-800"><span class="text-gray-500">Especialidad</span><span>{{ $docente->especialidad ?? '—' }}</span></div>
            <div class="flex justify-between py-1.5"><span class="text-gray-500">Grupos</span><span>{{ $docente->grupos->count() }}</span></div>
        </div>
    </div>
</div>
@endsection