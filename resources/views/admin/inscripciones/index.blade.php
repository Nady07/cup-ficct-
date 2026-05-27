@extends('layouts.admin')

@section('title', 'Gestión de Inscripciones')

@section('content')
<div class="animate-fade-in">
    <h2 class="text-2xl font-bold mb-6">📨 Inscripciones al CUP</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-dark-surface">
                        <th class="text-left p-3 text-sm font-semibold">Estudiante</th>
                        <th class="text-left p-3 text-sm font-semibold">Grupo</th>
                        <th class="text-left p-3 text-sm font-semibold">Fecha</th>
                        <th class="text-center p-3 text-sm font-semibold">Monto</th>
                        <th class="text-center p-3 text-sm font-semibold">Estado</th>
                        <th class="text-center p-3 text-sm font-semibold">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscripciones as $inscripcion)
                    <tr class="table-row-hover border-t">
                        <td class="p-3">{{ $inscripcion->estudiante->apellidos ?? 'N/A' }} {{ $inscripcion->estudiante->nombre ?? '' }}</td>
                        <td class="p-3 font-bold">{{ $inscripcion->grupo->codigo ?? 'N/A' }}</td>
                        <td class="p-3">{{ $inscripcion->fecha_inscripcion }}</td>
                        <td class="p-3 text-center">Bs. {{ $inscripcion->monto_pagado ?? '0.00' }}</td>
                        <td class="p-3 text-center">
                            <form action="{{ route('admin.inscripciones.updateEstado', $inscripcion) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="estado" onchange="this.form.submit()" class="text-xs rounded px-2 py-1 border-gray-300 dark:bg-dark-surface">
                                    <option value="pendiente" {{ $inscripcion->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $inscripcion->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="rechazado" {{ $inscripcion->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="completado" {{ $inscripcion->estado === 'completado' ? 'selected' : '' }}>Completado</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $inscripcion->estado === 'confirmado' ? 'bg-green-100 text-green-800' : ($inscripcion->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $inscripcion->estado }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-500">No hay inscripciones registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t">{{ $inscripciones->links() }}</div>
    </div>
</div>
@endsection