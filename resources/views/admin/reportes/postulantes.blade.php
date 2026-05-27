@extends('layouts.admin')

@section('title', 'Lista de Postulantes')

@section('content')
<div class="animate-fade-in space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">📋 Lista General de Postulantes</h1>
            <p class="text-sm text-gray-500">Total: {{ $estudiantes->total() }} postulantes</p>
        </div>
        <div class="flex gap-2">
            <span class="text-sm text-gray-500">Exportar:</span>
            <button class="text-sm text-blue-600 hover:text-blue-800">PDF</button>
            <button class="text-sm text-green-600 hover:text-green-800">Excel</button>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border">
        <div class="table-responsive">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-dark-surface border-b">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Postulante</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">CI</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Carrera</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Grupo</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Inscripción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @forelse($estudiantes as $index => $estudiante)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $estudiantes->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium">{{ $estudiante->apellidos }} {{ $estudiante->nombre }}</td>
                        <td class="px-4 py-3 font-mono text-sm">{{ $estudiante->ci }}</td>
                        <td class="px-4 py-3 text-sm">{{ $estudiante->carreraInteres->nombre ?? 'No definida' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $estudiante->inscripcion->grupo->codigo ?? 'No inscrito' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $estudiante->inscripcion && $estudiante->inscripcion->estado === 'confirmado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $estudiante->inscripcion->estado ?? 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-500">No hay postulantes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">{{ $estudiantes->links() }}</div>
    </div>
</div>
@endsection