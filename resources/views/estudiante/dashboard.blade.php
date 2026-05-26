<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Bienvenido, {{ $estudiante->nombre }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Dashboard académico - FICCT</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-dark-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Resumen Académico -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-stat-box 
                    label="Promedio"
                    :value="$promedio"
                    color="ficct-blue"
                    icon="<svg class='w-6 h-6 text-ficct-blue' fill='currentColor' viewBox='0 0 20 20'><path d='M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z'></path></svg>"
                />

                <x-stat-box 
                    label="Aprobadas"
                    :value="$aprobadas"
                    color="ficct-blue"
                    icon="<svg class='w-6 h-6 text-green-500' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'></path></svg>"
                />

                <x-stat-box 
                    label="Reprobadas"
                    :value="$reprobadas"
                    color="ficct-blue"
                    icon="<svg class='w-6 h-6 text-red-500' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'></path></svg>"
                />

                <x-stat-box 
                    label="Inscritas"
                    :value="$inscripciones->count()"
                    color="ficct-blue"
                    icon="<svg class='w-6 h-6 text-ficct-gold' fill='currentColor' viewBox='0 0 20 20'><path d='M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z'></path></svg>"
                />
            </div>

            <!-- Acceso Rápido -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Acceso Rápido</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('estudiante.horario') }}" class="bg-white dark:bg-dark-surface border-2 border-ficct-blue hover:bg-ficct-blue hover:text-white dark:hover:bg-ficct-dark-blue transition-all duration-200 rounded-lg p-6 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 fill-current" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 011-1h12a1 1 0 011 1H3zm0 4h16v2H3V5zm0 4h16v2H3V9zm0 4h16v2H3v-2z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Mi Horario</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ver clases y turnos</p>
                    </a>

                    <a href="{{ route('estudiante.materias') }}" class="bg-white dark:bg-dark-surface border-2 border-ficct-blue hover:bg-ficct-blue hover:text-white dark:hover:bg-ficct-dark-blue transition-all duration-200 rounded-lg p-6 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 fill-current" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Mis Materias</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Calificaciones y estado</p>
                    </a>

                    <a href="{{ route('estudiante.docentes') }}" class="bg-white dark:bg-dark-surface border-2 border-ficct-blue hover:bg-ficct-blue hover:text-white dark:hover:bg-ficct-dark-blue transition-all duration-200 rounded-lg p-6 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 fill-current" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6v12h6V6a3 3 0 11-6 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Docentes</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Información de profesores</p>
                    </a>

                    <a href="{{ route('estudiante.cup') }}" class="bg-white dark:bg-dark-surface border-2 border-ficct-blue hover:bg-ficct-blue hover:text-white dark:hover:bg-ficct-dark-blue transition-all duration-200 rounded-lg p-6 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 fill-current" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2h2a2 2 0 012 2v9a2 2 0 01-2 2H2a2 2 0 01-2-2v-9a2 2 0 012-2h2V5z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900 dark:text-white">CUP</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Información y requisitos</p>
                    </a>
                </div>
            </div>

            <!-- Últimas Calificaciones -->
            @if($calificaciones->count() > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Últimas Calificaciones</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($calificaciones->sortByDesc('updated_at')->take(6) as $calif)
                            <x-materia-card 
                                :materia="$calif->materia ?? (object)['nombre' => 'N/A', 'codigo' => 'N/A']"
                                :calificacion="$calif"
                                :estado="$calif->nota >= 51 ? 'aprobado' : 'reprobado'"
                            />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Clases Próximas -->
            @if($inscripciones->count() > 0)
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Mis Clases Inscritas</h3>
                    <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg overflow-hidden border border-gray-200 dark:border-dark-border">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-ficct-blue dark:bg-ficct-dark-blue text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold">Código</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold">Turno</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold">Horario</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold">Docente</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                                    @forelse($inscripciones as $insc)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface transition-colors">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $insc->grupo->codigo ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $insc->grupo->turno ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $insc->grupo->horario_inicio ?? 'N/A' }} - {{ $insc->grupo->horario_fin ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $insc->grupo->docente->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <x-status-badge :status="$insc->estado" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                                No hay inscripciones activas
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>