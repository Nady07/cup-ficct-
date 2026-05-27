@extends('layouts.admin')

@section('title', 'Postulantes')

@section('content')
<div class="animate-fade-in space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Postulantes a Docentes</h1>
            <p class="text-sm text-gray-500">Docentes que enviaron su postulación</p>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-dark-surface border-b">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Docente</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Requisitos</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Estado</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-dark-border">
                    @forelse($docentes as $docente)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface/50">
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.docentes.show', $docente) }}" class="flex items-center gap-3 group">
                                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-xs font-bold text-purple-600">
                                    {{ strtoupper(substr($docente->nombre, 0, 1)) }}{{ strtoupper(substr($docente->apellidos, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium group-hover:text-blue-600">{{ $docente->apellidos }}, {{ $docente->nombre }}</p>
                                    <p class="text-xs text-gray-400">{{ $docente->especialidad ?? 'Sin especialidad' }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-sm font-medium {{ $docente->cumpleRequisitosObligatorios() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $docente->requisitos_presentados }}/{{ $docente->requisitos_cumplidos > 0 ? 4 : '?' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $docente->estado_postulacion === 'aprobado' ? 'bg-green-50 text-green-700' : 
                                   ($docente->estado_postulacion === 'rechazado' ? 'bg-red-50 text-red-700' : 
                                   'bg-yellow-50 text-yellow-700') }}">
                                {{ ucfirst($docente->estado_postulacion) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">
                            {{ $docente->fecha_postulacion ? $docente->fecha_postulacion->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('admin.docentes.show', $docente) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Revisar →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500">No hay postulantes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection