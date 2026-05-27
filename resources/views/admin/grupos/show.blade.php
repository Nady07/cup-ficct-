@extends('layouts.admin')

@section('title', 'Detalle del Grupo')

@section('content')
<div class="animate-fade-in">
    <div class="mb-6">
        <a href="{{ route('admin.grupos.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a grupos
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info del Grupo -->
        <div class="lg:col-span-1">
            <div class="card">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información del Grupo
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Código:</span>
                        <span class="font-bold font-mono">{{ $grupo->codigo }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Turno:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $grupo->turno === 'M' ? 'bg-yellow-100 text-yellow-800' : 
                               ($grupo->turno === 'T' ? 'bg-blue-100 text-blue-800' : 
                               'bg-purple-100 text-purple-800') }}">
                            {{ $grupo->turno === 'M' ? '🌅 Mañana' : ($grupo->turno === 'T' ? '☀️ Tarde' : '🌙 Noche') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Horario:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($grupo->horario_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($grupo->horario_fin)->format('H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Capacidad:</span>
                        <span class="font-medium">{{ $grupo->capacidad_maxima }} estudiantes</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Inscritos:</span>
                        <span class="font-bold {{ $grupo->estudiantes_inscritos >= $grupo->capacidad_maxima ? 'text-red-600' : 'text-green-600' }}">
                            {{ $grupo->estudiantes_inscritos }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Docente:</span>
                        <span class="font-medium">{{ $grupo->docente->apellidos ?? 'Sin asignar' }} {{ $grupo->docente->nombre ?? '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Estado:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $grupo->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $grupo->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-dark-border">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        @php $porcentaje = ($grupo->estudiantes_inscritos / $grupo->capacidad_maxima) * 100; @endphp
                        <div class="h-3 rounded-full {{ $porcentaje >= 100 ? 'bg-red-500' : ($porcentaje >= 80 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                             style="width: {{ $porcentaje }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ number_format($porcentaje, 1) }}% ocupado</p>
                </div>
            </div>
        </div>

        <!-- Estudiantes Inscritos -->
        <div class="lg:col-span-2">
            <div class="card">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Estudiantes Inscritos
                </h3>
                @if($grupo->inscripciones->count() > 0)
                    <div class="table-responsive">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-dark-surface">
                                    <th class="text-left p-3 text-sm font-semibold">Estudiante</th>
                                    <th class="text-left p-3 text-sm font-semibold">CI</th>
                                    <th class="text-left p-3 text-sm font-semibold">Fecha Inscripción</th>
                                    <th class="text-center p-3 text-sm font-semibold">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupo->inscripciones as $inscripcion)
                                <tr class="table-row-hover border-t">
                                    <td class="p-3">{{ $inscripcion->estudiante->apellidos }} {{ $inscripcion->estudiante->nombre }}</td>
                                    <td class="p-3">{{ $inscripcion->estudiante->ci }}</td>
                                    <td class="p-3">{{ $inscripcion->fecha_inscripcion }}</td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $inscripcion->estado === 'confirmado' ? 'bg-green-100 text-green-800' : 
                                               ($inscripcion->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $inscripcion->estado }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-500">No hay estudiantes inscritos en este grupo</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection