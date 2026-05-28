@extends('layouts.admin')

@section('title', 'Calificaciones')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Calificaciones</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $calificaciones->total() }} registros · 3 exámenes · Mínimo {{ \App\Models\Calificacion::NOTA_MINIMA_APROBACION }} pts
            </p>
        </div>
        <x-btn-primary :route="route('admin.calificaciones.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva
        </x-btn-primary>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card title="Total" :value="$calificaciones->total()" color="blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </x-stat-card>
        <x-stat-card title="Aprobados" :value="$calificaciones->where('estado', 'aprobado')->count()" color="green">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Reprobados" :value="$calificaciones->where('estado', 'reprobado')->count()" color="red">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>
        <x-stat-card title="Promedio" :value="number_format($calificaciones->avg('promedio') ?? 0, 1)" color="purple">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </x-stat-card>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left px-4 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Estudiante</th>
                        <th class="text-left px-4 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Materia</th>
                        <th class="text-center px-2 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-12">N1</th>
                        <th class="text-center px-2 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-12">N2</th>
                        <th class="text-center px-2 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-12">N3</th>
                        <th class="text-center px-2 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-14">Prom</th>
                        <th class="text-center px-2 py-2.5 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Estado</th>
                        <th class="text-center px-2 py-2.5 w-12"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($calificaciones as $cal)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap text-xs">
                            {{ $cal->estudiante->apellidos ?? '—' }}, {{ substr($cal->estudiante->nombre ?? '', 0, 1) }}.
                        </td>
                        <td class="px-4 py-2 text-gray-500 dark:text-gray-400 whitespace-nowrap text-xs">{{ $cal->materia->nombre ?? '—' }}</td>
                        <td class="px-2 py-2 text-center text-gray-600 dark:text-gray-400 text-xs">{{ number_format($cal->nota1, 1) }}</td>
                        <td class="px-2 py-2 text-center text-gray-600 dark:text-gray-400 text-xs">{{ number_format($cal->nota2, 1) }}</td>
                        <td class="px-2 py-2 text-center text-gray-600 dark:text-gray-400 text-xs">{{ number_format($cal->nota3, 1) }}</td>
                        <td class="px-2 py-2 text-center font-semibold text-xs {{ $cal->estado === 'aprobado' ? 'text-green-600' : 'text-red-600' }}">{{ $cal->promedio_formateado }}</td>
                        <td class="px-2 py-2 text-center">
                            <span class="inline-flex px-1.5 py-0.5 rounded text-xs font-medium {{ $cal->estado === 'aprobado' ? 'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300' : 'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300' }}">
                                {{ $cal->estado === 'aprobado' ? 'Apr' : 'Rep' }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-center">
                            <div class="flex justify-center gap-0.5">
                                <button @click="$dispatch('open-modal', 'editar-calificacion'); setEditar({{ $cal->id }}, {{ $cal->estudiante_id }}, {{ $cal->materia_id }}, {{ $cal->nota1 }}, {{ $cal->nota2 }}, {{ $cal->nota3 }})"
                                        class="p-1 text-gray-400 hover:text-blue-600 rounded" title="Editar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.calificaciones.destroy', $cal) }}" method="POST" onsubmit="return confirm('¿Eliminar?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-1 text-gray-400 hover:text-red-600 rounded" title="Eliminar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <x-empty-state message="Sin calificaciones" :cols="8" />
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($calificaciones->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800">{{ $calificaciones->links() }}</div>
        @endif
    </div>
</div>

{{-- Modal con Alpine.js (Breeze) --}}
<x-modal name="editar-calificacion" maxWidth="sm">
    <div class="p-5">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Editar Calificación</h3>
        <form id="formEditar" method="POST">
            @csrf @method('PUT')
            <input type="hidden" id="estudiante_id" name="estudiante_id">
            <input type="hidden" id="materia_id" name="materia_id">
            <div class="space-y-3">
                @foreach([1,2,3] as $i)
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Examen {{ $i }}</label>
                    <input type="number" id="nota{{ $i }}" name="nota{{ $i }}" step="0.01" min="0" max="100" required
                           class="input-ficct text-center" placeholder="0 - 100">
                </div>
                @endforeach
            </div>
            <div class="flex gap-2 justify-end mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                <button type="button" @click="$dispatch('close-modal', 'editar-calificacion')" class="btn-secondary text-sm">Cancelar</button>
                <button type="submit" class="btn-primary text-sm">Actualizar</button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    function setEditar(id, estudianteId, materiaId, n1, n2, n3) {
        document.getElementById('estudiante_id').value = estudianteId;
        document.getElementById('materia_id').value = materiaId;
        document.getElementById('nota1').value = n1;
        document.getElementById('nota2').value = n2;
        document.getElementById('nota3').value = n3;
        document.getElementById('formEditar').action = '/admin/calificaciones/' + id;
    }
</script>
@endsection