@extends('layouts.admin')

@section('title', 'Gestión de Estudiantes')

@section('content')
<div class="animate-fade-in">
    <!-- Header con estadísticas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="card border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Total Estudiantes</p>
            <p class="text-3xl font-bold text-blue-600">{{ $estudiantes->total() }}</p>
        </div>
        <div class="card border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Inscritos Confirmados</p>
            <p class="text-3xl font-bold text-green-600">{{ $estudiantes->where('inscripcion.estado', 'confirmado')->count() }}</p>
        </div>
        <div class="card border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Pendientes</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $estudiantes->where('inscripcion.estado', 'pendiente')->count() }}</p>
        </div>
        <div class="card border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">CUP Aprobado</p>
            <p class="text-3xl font-bold text-purple-600">
                {{ $estudiantes->filter(fn($e) => $e->aproboCUP())->count() }}
            </p>
        </div>
    </div>

    <!-- Título y botón -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Estudiantes
        </h2>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Buscador -->
            <div class="relative">
                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                       placeholder="Buscar por nombre, apellido o CI..." 
                       class="input-ficct pl-10">
            </div>

            <!-- Filtro por Carrera -->
            <select name="carrera_id" class="input-ficct">
                <option value="">Todas las carreras</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>

            <!-- Filtro por Estado Inscripción -->
            <select name="estado_inscripcion" class="input-ficct">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado_inscripcion') === 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                <option value="confirmado" {{ request('estado_inscripcion') === 'confirmado' ? 'selected' : '' }}>✅ Confirmado</option>
                <option value="completado" {{ request('estado_inscripcion') === 'completado' ? 'selected' : '' }}>🎓 Completado</option>
                <option value="rechazado" {{ request('estado_inscripcion') === 'rechazado' ? 'selected' : '' }}>❌ Rechazado</option>
            </select>

            <!-- Botones -->
            <div class="flex gap-2">
                <button type="submit" class="btn-primary flex items-center gap-2 flex-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn-secondary flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Resultados -->
    <div class="card">
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-dark-border">
            <p class="text-sm text-gray-500">
                Mostrando {{ $estudiantes->firstItem() ?? 0 }} - {{ $estudiantes->lastItem() ?? 0 }} de {{ $estudiantes->total() }} estudiantes
            </p>
            <div class="flex gap-2">
                <button onclick="exportarTabla()" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-dark-surface border-b border-gray-200 dark:border-dark-border">
                        <th class="text-left p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">#</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Estudiante</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">CI</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Carrera</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Grupo</th>
                        <th class="text-center p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Inscripción</th>
                        <th class="text-center p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Notas</th>
                        <th class="text-center p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">CUP</th>
                        <th class="text-center p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $index => $estudiante)
                    <tr class="table-row-hover border-b border-gray-100 dark:border-dark-border transition-colors">
                        {{-- Número --}}
                        <td class="p-4 text-sm text-gray-400">{{ $estudiantes->firstItem() + $index }}</td>
                        
                        {{-- Nombre --}}
                        <td class="p-4">
                            <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="hover:underline">
                                <p class="font-medium">{{ $estudiante->apellidos }}</p>
                                <p class="text-sm text-gray-500">{{ $estudiante->nombre }}</p>
                            </a>
                        </td>
                        
                        {{-- CI --}}
                        <td class="p-4 font-mono text-sm">{{ $estudiante->ci }}</td>
                        
                        {{-- Carrera --}}
                        <td class="p-4">
                            @if($estudiante->carreraInteres)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded text-xs font-semibold">
                                    {{ $estudiante->carreraInteres->codigo }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $estudiante->carreraInteres->nombre }}</p>
                            @else
                                <span class="text-gray-400 text-sm">No definida</span>
                            @endif
                        </td>
                        
                        {{-- Grupo --}}
                        <td class="p-4">
                            @if($estudiante->inscripcion && $estudiante->inscripcion->grupo)
                                <span class="font-mono font-bold text-sm">{{ $estudiante->inscripcion->grupo->codigo }}</span>
                                <p class="text-xs text-gray-500">
                                    {{ $estudiante->inscripcion->grupo->turno === 'M' ? '🌅 Mañana' : ($estudiante->inscripcion->grupo->turno === 'T' ? '☀️ Tarde' : '🌙 Noche') }}
                                    • {{ \Carbon\Carbon::parse($estudiante->inscripcion->grupo->horario_inicio)->format('H:i') }}
                                </p>
                            @else
                                <span class="text-gray-400 text-sm">No inscrito</span>
                            @endif
                        </td>
                        
                        {{-- Estado Inscripción --}}
                        <td class="p-4 text-center">
                            @if($estudiante->inscripcion)
                                @php $estado = $estudiante->inscripcion->estado; @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $estado === 'confirmado' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                       ($estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                       ($estado === 'completado' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200')) }}">
                                    {{ ucfirst($estado) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        
                        {{-- Notas --}}
                        <td class="p-4 text-center">
                            @php
                                $aprobadas = $estudiante->materiasAprobadas();
                                $total = 4;
                                $promedio = $estudiante->promedio();
                            @endphp
                            <div class="flex items-center justify-center gap-1">
                                <span class="font-bold {{ $promedio >= 60 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($promedio, 1) }}
                                </span>
                                <span class="text-xs text-gray-400">pts</span>
                            </div>
                            <div class="flex justify-center gap-1 mt-1">
                                @for($i = 1; $i <= $total; $i++)
                                    <div class="w-2 h-2 rounded-full {{ $i <= $aprobadas ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $aprobadas }}/{{ $total }}</p>
                        </td>
                        
                        {{-- Estado CUP --}}
                        <td class="p-4 text-center">
                            @if($estudiante->aproboCUP())
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 flex items-center justify-center gap-1">
                                    🎓 APROBADO
                                </span>
                            @elseif($estudiante->materiasReprobadas() > 0)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    ⚠️ En riesgo
                                </span>
                            @elseif($aprobadas > 0)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    📚 En curso
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        
                        {{-- Acciones --}}
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Ver --}}
                                <a href="{{ route('admin.estudiantes.show', $estudiante) }}" 
                                   class="text-green-600 hover:text-green-800 dark:text-green-400 p-1 rounded hover:bg-green-50 dark:hover:bg-green-900" 
                                   title="Ver perfil completo">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                {{-- Editar --}}
                                <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900" 
                                   title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-12 text-center">
                            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-500 mb-2">No se encontraron estudiantes</h3>
                            <p class="text-gray-400">
                                @if(request('buscar') || request('carrera_id') || request('estado_inscripcion'))
                                    Intenta con otros filtros de búsqueda.
                                @else
                                    Aún no hay estudiantes registrados en el sistema.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="p-4 border-t border-gray-200 dark:border-dark-border flex justify-between items-center">
            <p class="text-sm text-gray-500">
                Página {{ $estudiantes->currentPage() }} de {{ $estudiantes->lastPage() }}
            </p>
            {{ $estudiantes->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function exportarTabla() {
        alert('Funcionalidad de exportación en desarrollo.');
        // Aquí puedes agregar exportación a Excel/PDF
    }
</script>
@endsection