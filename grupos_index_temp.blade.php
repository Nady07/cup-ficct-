@extends('layouts.admin')

@section('title', 'Grupos')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Gestión de Grupos</h1>
        <a href="{{ route('admin.grupos.create') }}" class="inline-flex items-center space-x-2 bg-ficct-blue hover:bg-ficct-light-blue text-white px-6 py-3 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            <span>Nuevo</span>
        </a>
    </div>

    @forelse($grupos as $grupo)
        <div class="bg-white dark:bg-dark-surface rounded-lg p-6">
            <h3 class="font-bold text-lg">{{ $grupo->codigo }} - {{ $grupo->turno }}</h3>
            <p>Horario: {{ $grupo->horario_inicio }} - {{ $grupo->horario_fin }}</p>
            <p>Inscritos: {{ $grupo->inscripciones_count ?? 0 }} / {{ $grupo->capacidad_maxima }}</p>
        </div>
    @empty
        <p class="text-center">No hay grupos</p>
    @endforelse
</div>
@endsection
