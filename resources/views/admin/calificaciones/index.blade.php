@extends('layouts.admin')

@section('title', 'Calificaciones')

@section('content')
<div class="animate-fade-in space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Calificaciones</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $calificaciones->total() }} registros · 3 exámenes por materia · Mínimo 60 pts</p>
        </div>
        <a href="{{ route('admin.calificaciones.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Calificación
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total registros</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $calificaciones->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Aprobados</p>
                    <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $calificaciones->where('estado', 'aprobado')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Reprobados</p>
                    <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $calificaciones->where('estado', 'reprobado')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Promedio general</p>
                    <p class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($calificaciones->avg('promedio') ?? 0, 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white dark:bg-dark-surface rounded-xl border border-gray-100 dark:border-dark-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-dark-surface border-b border-gray-100 dark:border-dark-border">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estudiante</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Materia</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ex. 1</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ex. 2</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ex. 3</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Promedio</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-dark-border">
                    @forelse($calificaciones as $cal)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-dark-surface/50 transition-colors">
                        <td class="px-5 py-3 text-sm font-medium text-gray-900 dark:text-white">
                            {{ $cal->estudiante->apellidos ?? 'N/A' }} {{ $cal->estudiante->nombre ?? '' }}
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-gray-400">
                            {{ $cal->materia->nombre ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-600 dark:text-gray-400">{{ number_format($cal->nota1, 1) }}</td>
                        <td class="px-3 py-3 text-center text-sm text-gray-600 dark:text-gray-400">{{ number_format($cal->nota2, 1) }}</td>
                        <td class="px-3 py-3 text-center text-sm text-gray-600 dark:text-gray-400">{{ number_format($cal->nota3, 1) }}</td>
                        <td class="px-3 py-3 text-center text-sm font-bold {{ $cal->promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($cal->promedio, 1) }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $cal->estado === 'aprobado' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-300' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300' }}">
                                {{ $cal->estado === 'aprobado' ? 'Aprobado' : 'Reprobado' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="flex justify-center gap-1">
                                <button onclick="editar({{ $cal->id }}, {{ $cal->nota1 }}, {{ $cal->nota2 }}, {{ $cal->nota3 }})" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.calificaciones.destroy', $cal) }}" method="POST" onsubmit="return confirm('¿Eliminar?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-500 dark:text-gray-400">
                            <p class="font-medium mb-1">Sin calificaciones</p>
                            <p class="text-sm">Registra la primera calificación.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($calificaciones->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-border">{{ $calificaciones->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditar" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-dark-surface rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4 animate-fade-in">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Editar Notas</h3>
            <button onclick="cerrarModal()" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="formEditar" method="POST">
            @csrf @method('PUT')
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">1er Examen</label>
                    <input type="number" id="nota1" name="nota1" step="0.01" min="0" max="100" required class="input-ficct text-center">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">2do Examen</label>
                    <input type="number" id="nota2" name="nota2" step="0.01" min="0" max="100" required class="input-ficct text-center">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">3er Examen</label>
                    <input type="number" id="nota3" name="nota3" step="0.01" min="0" max="100" required class="input-ficct text-center">
                </div>
            </div>
            <div class="flex gap-2 justify-end mt-5">
                <button type="button" onclick="cerrarModal()" class="btn-secondary text-sm">Cancelar</button>
                <button type="submit" class="btn-primary text-sm">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editar(id, n1, n2, n3) {
        document.getElementById('modalEditar').classList.remove('hidden');
        document.getElementById('nota1').value = n1;
        document.getElementById('nota2').value = n2;
        document.getElementById('nota3').value = n3;
        document.getElementById('formEditar').action = '/admin/calificaciones/' + id;
    }
    function cerrarModal() { document.getElementById('modalEditar').classList.add('hidden'); }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
    document.getElementById('modalEditar').addEventListener('click', function(e) { if (e.target === this) cerrarModal(); });
</script>
@endsection