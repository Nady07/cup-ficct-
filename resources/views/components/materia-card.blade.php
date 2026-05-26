@props(['materia', 'docente' => null, 'calificacion' => null, 'estado' => null])

<div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-4 hover:shadow-lg dark:hover:shadow-2xl transition-all duration-200 cursor-pointer">
    <div class="flex justify-between items-start mb-3">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $materia->nombre ?? $materia->code ?? 'N/A' }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $materia->codigo ?? '' }}</p>
        </div>
        @if($estado)
            <span class="px-3 py-1 text-xs font-semibold rounded-full
                @if($estado === 'aprobado')
                    bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                @elseif($estado === 'reprobado')
                    bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                @elseif($estado === 'inscrito')
                    bg-ficct-blue text-white
                @else
                    bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                @endif
            ">
                {{ ucfirst($estado) }}
            </span>
        @endif
    </div>

    @if($docente)
        <div class="mb-3">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                <span class="font-medium">Docente:</span> {{ $docente->nombre ?? 'N/A' }} {{ $docente->apellidos ?? '' }}
            </p>
        </div>
    @endif

    @if($calificacion)
        <div class="flex items-center justify-between py-3 border-t border-gray-200 dark:border-dark-border">
            <span class="text-gray-700 dark:text-gray-300">Calificación:</span>
            <span class="text-2xl font-bold text-ficct-blue dark:text-ficct-gold">
                {{ $calificacion->nota ?? '--' }}
            </span>
        </div>
    @endif

    {{ $slot }}
</div>
