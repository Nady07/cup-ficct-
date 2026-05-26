<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">CUP - Ciclo de Ubicación Preparatoria</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Información completa del programa para FICCT-UAGRM</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-dark-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Introducción CUP -->
            <div class="bg-gradient-to-r from-ficct-blue to-ficct-dark-blue dark:from-ficct-dark-blue dark:to-ficct-blue p-8 rounded-lg shadow-lg text-white mb-12">
                <h3 class="text-2xl font-bold mb-2">¿Qué es el CUP?</h3>
                <p class="text-blue-100 mb-4">
                    El Ciclo de Ubicación Preparatoria (CUP) es un programa de la Universidad Autónoma Gabriel René Moreno (UAGRM) que prepara a estudiantes de nuevo ingreso para el sistema académico universitario.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-white bg-opacity-10 p-4 rounded">
                        <p class="text-sm font-semibold mb-1">Duración</p>
                        <p class="text-lg">2-3 meses aproximadamente</p>
                    </div>
                    <div class="bg-white bg-opacity-10 p-4 rounded">
                        <p class="text-sm font-semibold mb-1">Objetivo</p>
                        <p class="text-lg">Nivelar conocimientos</p>
                    </div>
                    <div class="bg-white bg-opacity-10 p-4 rounded">
                        <p class="text-sm font-semibold mb-1">Requisito</p>
                        <p class="text-lg">Todos los estudiantes nuevos</p>
                    </div>
                </div>
            </div>

            <!-- Materias CUP -->
            @if($materiasCup->count() > 0)
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Materias del CUP</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($materiasCup as $materia)
                            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border-l-4 border-ficct-blue dark:border-ficct-gold p-6 hover:shadow-lg transition-all">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $materia->nombre }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Código: {{ $materia->codigo }}
                                        </p>
                                    </div>
                                </div>

                                @if($materia->descripcion)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                                        {{ $materia->descripcion }}
                                    </p>
                                @endif

                                <div class="py-4 border-y border-gray-200 dark:border-dark-border space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Nota Mínima:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ $materia->nota_minima ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Puntaje:</span>
                                        <span class="font-semibold text-ficct-blue dark:text-ficct-gold">
                                            {{ $materia->valor_puntaje ?? 0 }} pts
                                        </span>
                                    </div>
                                </div>

                                @if(isset($requisitosPorMateria[$materia->id]) && $requisitosPorMateria[$materia->id]->count() > 0)
                                    <div class="mt-4">
                                        <h5 class="font-semibold text-gray-900 dark:text-white text-sm mb-2">Requisitos:</h5>
                                        <ul class="space-y-1">
                                            @foreach($requisitosPorMateria[$materia->id] as $req)
                                                <li class="text-xs text-gray-600 dark:text-gray-400 flex items-center">
                                                    <span class="w-1.5 h-1.5 bg-ficct-blue dark:bg-ficct-gold rounded-full mr-2 flex-shrink-0"></span>
                                                    {{ $req->descripcion ?? 'Requisito especial' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Criterios de Evaluación -->
            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-8 mb-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Criterios de Evaluación</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold text-ficct-blue dark:text-ficct-gold mb-3 text-lg">Escala de Calificación</h4>
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                                <tr>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">Excelente</td>
                                    <td class="py-2 font-semibold text-gray-900 dark:text-white">90-100</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">Muy Bueno</td>
                                    <td class="py-2 font-semibold text-gray-900 dark:text-white">80-89</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">Bueno</td>
                                    <td class="py-2 font-semibold text-gray-900 dark:text-white">70-79</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">Aprobado</td>
                                    <td class="py-2 font-semibold text-gray-900 dark:text-white">51-69</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">Reprobado</td>
                                    <td class="py-2 font-semibold text-red-600 dark:text-red-400">0-50</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <h4 class="font-semibold text-ficct-blue dark:text-ficct-gold mb-3 text-lg">Puntaje Total CUP</h4>
                        <div class="bg-gray-50 dark:bg-dark-bg p-6 rounded-lg">
                            <div class="text-center mb-4">
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">Puntaje Máximo</p>
                                <p class="text-4xl font-bold text-ficct-blue dark:text-ficct-gold">
                                    {{ $materiasCup->sum('valor_puntaje') ?? 100 }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                La suma de todos los puntajes de materias determina tu clasificación y acceso a carreras
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Importante -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 border-l-4 border-yellow-400 p-6 rounded">
                    <h4 class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Importante
                    </h4>
                    <ul class="space-y-2 text-sm text-yellow-800 dark:text-yellow-200">
                        <li>• La asistencia es obligatoria</li>
                        <li>• No hay recuperaciones de exámenes</li>
                        <li>• Participación activa en clases</li>
                        <li>• Tareas y trabajos son evaluados</li>
                    </ul>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900 dark:bg-opacity-20 border-l-4 border-ficct-blue p-6 rounded">
                    <h4 class="font-semibold text-ficct-blue dark:text-ficct-light-blue mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        Apoyo Disponible
                    </h4>
                    <ul class="space-y-2 text-sm text-ficct-blue dark:text-ficct-light-blue">
                        <li>• Tutorías personalizadas</li>
                        <li>• Grupos de estudio</li>
                        <li>• Recursos en línea</li>
                        <li>• Orientación académica</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>