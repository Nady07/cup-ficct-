@props(['docente'])

<div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-6 hover:shadow-lg dark:hover:shadow-2xl transition-all duration-200">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $docente->nombre ?? 'N/A' }} {{ $docente->apellidos ?? '' }}
            </h3>
            <p class="text-sm text-ficct-blue dark:text-ficct-gold font-medium">
                {{ $docente->especialidad ?? 'Sin especialidad' }}
            </p>
        </div>
        <div class="w-12 h-12 bg-ficct-blue dark:bg-ficct-dark-blue rounded-full flex items-center justify-center">
            <span class="text-white text-lg font-bold">
                {{ strtoupper(substr($docente->nombre ?? 'D', 0, 1)) }}
            </span>
        </div>
    </div>

    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
        @if($docente->email)
            <div class="flex items-center">
                <span class="font-medium text-gray-900 dark:text-white w-20">Email:</span>
                <a href="mailto:{{ $docente->email }}" class="text-ficct-blue dark:text-ficct-gold hover:underline">
                    {{ $docente->email }}
                </a>
            </div>
        @endif

        @if($docente->telefono)
            <div class="flex items-center">
                <span class="font-medium text-gray-900 dark:text-white w-20">Teléfono:</span>
                <a href="tel:{{ $docente->telefono }}" class="text-ficct-blue dark:text-ficct-gold hover:underline">
                    {{ $docente->telefono }}
                </a>
            </div>
        @endif

        @if($docente->ci)
            <div class="flex items-center">
                <span class="font-medium text-gray-900 dark:text-white w-20">C.I.:</span>
                <span>{{ $docente->ci }}</span>
            </div>
        @endif

        @if($docente->experiencia)
            <div class="flex items-center">
                <span class="font-medium text-gray-900 dark:text-white w-20">Experiencia:</span>
                <span>{{ $docente->experiencia }} años</span>
            </div>
        @endif
    </div>

    {{ $slot }}
</div>
