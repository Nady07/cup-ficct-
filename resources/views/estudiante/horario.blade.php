<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mi Horario de Clases</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Vista de tus clases por turno</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-dark-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @forelse($turnos as $turno => $gruposDelTurno)
                <div class="mb-12">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-ficct-blue dark:text-ficct-gold mb-1">
                            Turno: {{ ucfirst($turno) }}
                        </h3>
                        <div class="h-1 w-20 bg-ficct-blue dark:bg-ficct-gold rounded"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($gruposDelTurno as $grupo)
                            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border-l-4 border-ficct-blue dark:border-ficct-gold p-6 hover:shadow-lg transition-all">
                                <div class="mb-4">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $grupo->codigo }}
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Grupo de la materia</p>
                                </div>

                                <div class="space-y-3 py-4 border-y border-gray-200 dark:border-dark-border">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-ficct-blue dark:text-ficct-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Horario</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $grupo->horario_inicio }} - {{ $grupo->horario_fin }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($grupo->docente)
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-5 h-5 text-ficct-blue dark:text-ficct-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6v12h6V6a3 3 0 11-6 0z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">Docente</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $grupo->docente->nombre }} {{ $grupo->docente->apellidos }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-ficct-blue dark:text-ficct-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Capacidad</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $grupo->estudiantes_inscritos }}/{{ $grupo->capacidad_maxima }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-status-badge :status="$grupo->estado" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg p-8 text-center border border-gray-200 dark:border-dark-border">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay clases</h3>
                    <p class="text-gray-600 dark:text-gray-400">No tienes inscripciones activas en este momento</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>