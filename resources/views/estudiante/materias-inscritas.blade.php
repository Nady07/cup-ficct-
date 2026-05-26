<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Materias</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Materias inscritas y calificaciones</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-dark-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(count($materias) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($materias as $materia)
                        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-6 hover:shadow-lg transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $materia['grupo']->codigo ?? 'N/A' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Grupo
                                    </p>
                                </div>
                                @if($materia['inscripcion'])
                                    <x-status-badge :status="$materia['inscripcion']->estado" />
                                @endif
                            </div>

                            <div class="py-4 border-y border-gray-200 dark:border-dark-border space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Turno:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $materia['grupo']->turno ?? 'N/A' }}
                                    </span>
                                </div>

                                @if($materia['grupo']->docente)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Docente:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ $materia['grupo']->docente->nombre ?? 'N/A' }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Horario:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $materia['grupo']->horario_inicio ?? 'N/A' }} - {{ $materia['grupo']->horario_fin ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            @if($materia['calificacion'])
                                <div class="mt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Calificación:</span>
                                        <span class="text-3xl font-bold text-ficct-blue dark:text-ficct-gold">
                                            {{ $materia['calificacion']->nota }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        @if($materia['calificacion']->nota >= 51)
                                            <x-status-badge status="aprobado" text="Aprobado" />
                                        @else
                                            <x-status-badge status="reprobado" text="Reprobado" />
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 rounded text-center">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        Calificación no registrada
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Resumen General -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Resumen Académico</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-dark-bg rounded-lg">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Inscritas</p>
                            <p class="text-3xl font-bold text-ficct-blue dark:text-ficct-gold mt-1">
                                {{ count($materias) }}
                            </p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-dark-bg rounded-lg">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Con Calificación</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">
                                {{ collect($materias)->filter(fn($m) => $m['calificacion'])->count() }}
                            </p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-dark-bg rounded-lg">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Promedio General</p>
                            <p class="text-3xl font-bold text-ficct-blue dark:text-ficct-gold mt-1">
                                {{ number_format(collect($materias)->map(fn($m) => $m['calificacion']?->nota ?? 0)->avg(), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg p-8 text-center border border-gray-200 dark:border-dark-border">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.248 6.253 2 10.998 2 16.5S6.248 26.747 12 26.747s10-4.745 10-10.247S17.752 6.253 12 6.253z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay materias inscritas</h3>
                    <p class="text-gray-600 dark:text-gray-400">Aún no tienes materias inscritas en este período</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>