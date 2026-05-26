<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Docentes</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Información de tus profesores</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-dark-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($docentes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($docentes as $docente)
                        <x-docente-card :docente="$docente">
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-dark-border">
                                <button class="w-full bg-ficct-blue dark:bg-ficct-dark-blue hover:bg-ficct-dark-blue dark:hover:bg-ficct-light-blue text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Ver Perfil Completo
                                </button>
                            </div>
                        </x-docente-card>
                    @endforeach
                </div>

                <!-- Información Adicional -->
                <div class="mt-12 bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Información de Contacto</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-ficct-blue bg-opacity-10 dark:bg-opacity-20 p-6 rounded-lg">
                            <h4 class="font-semibold text-ficct-blue dark:text-ficct-gold mb-2 text-lg">
                                Para Consultas Académicas
                            </h4>
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Puedes contactar a tus docentes durante sus horas de oficina o por correo electrónico.
                            </p>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li>• Verifique el horario de atención en el perfil del docente</li>
                                <li>• Responden correos dentro de 24-48 horas</li>
                                <li>• Participe en las sesiones de tutoría</li>
                            </ul>
                        </div>

                        <div class="bg-ficct-gold bg-opacity-10 dark:bg-opacity-20 p-6 rounded-lg">
                            <h4 class="font-semibold text-ficct-gold dark:text-ficct-light-gold mb-2 text-lg">
                                Soporte Académico
                            </h4>
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                La FICCT ofrece recursos de apoyo para ayudarte en tu aprendizaje.
                            </p>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li>• Centro de tutoría disponible</li>
                                <li>• Recursos en línea y biblioteca digital</li>
                                <li>• Grupos de estudio entre compañeros</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg p-8 text-center border border-gray-200 dark:border-dark-border">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292 4 4 0 010-5.292M15 21H3.623a1.623 1.623 0 01-1.623-1.623V5.448c0-.898.561-1.723 1.415-2.049.804-.31 1.584-.233 2.214.253l1.832 1.39a6 6 0 009.294 0l1.832-1.39c.63-.486 1.41-.563 2.214-.253.854.326 1.415 1.151 1.415 2.049v14.929c0 .896-.561 1.723-1.415 2.049"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay docentes asignados</h3>
                    <p class="text-gray-600 dark:text-gray-400">Primero debes inscribirse en materias para ver los docentes asignados</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>