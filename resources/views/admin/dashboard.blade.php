@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">📊 Panel de Control - CUP FICCT I/2025</h1>

<!-- Tarjetas de estadísticas -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Estudiantes</p>
        <p class="text-2xl font-bold">{{ $stats['estudiantes'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Grupos</p>
        <p class="text-2xl font-bold">{{ $stats['grupos'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
        <p class="text-sm text-gray-500">Docentes</p>
        <p class="text-2xl font-bold">{{ $stats['docentes'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-500">
        <p class="text-sm text-gray-500">Materias</p>
        <p class="text-2xl font-bold">{{ $stats['materias'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Carreras</p>
        <p class="text-2xl font-bold">{{ $stats['carreras'] }}</p>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">📝 Inscripciones Totales</p>
        <p class="text-2xl font-bold">{{ $stats['inscripciones'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">⏳ Pendientes</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['inscripciones_pendientes'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">✅ Confirmadas</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['inscripciones_confirmadas'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">🟢 Cupos Disponibles</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['grupos_disponibles'] }}/{{ $stats['grupos'] }}</p>
    </div>
</div>

<!-- Últimas inscripciones -->
<div class="bg-white rounded-lg shadow">
    <div class="p-4 border-b">
        <h2 class="text-lg font-bold">🕐 Últimas Inscripciones</h2>
    </div>
    <div class="p-4">
        @if($ultimasInscripciones->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-2">Estudiante</th>
                        <th class="text-left p-2">Grupo</th>
                        <th class="text-left p-2">Fecha</th>
                        <th class="text-left p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimasInscripciones as $inscripcion)
                    <tr class="border-t">
                        <td class="p-2">{{ $inscripcion->estudiante->nombre ?? 'N/A' }} {{ $inscripcion->estudiante->apellidos ?? '' }}</td>
                        <td class="p-2">{{ $inscripcion->grupo->codigo ?? 'N/A' }}</td>
                        <td class="p-2">{{ $inscripcion->fecha_inscripcion }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs 
                                {{ $inscripcion->estado === 'confirmado' ? 'bg-green-100 text-green-800' : 
                                   ($inscripcion->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $inscripcion->estado }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No hay inscripciones aún.</p>
        @endif
    </div>
</div>
@endsection