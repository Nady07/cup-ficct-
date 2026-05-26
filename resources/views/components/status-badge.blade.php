@props(['status', 'text' => null])

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
    @switch($status)
        @case('activa')
            bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
            @break
        @case('pendiente')
            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
            @break
        @case('cancelada')
            bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
            @break
        @case('aprobado')
            bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
            @break
        @case('reprobado')
            bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
            @break
        @case('activo')
            bg-ficct-blue bg-opacity-20 dark:bg-opacity-30 text-ficct-blue dark:text-ficct-light-blue
            @break
        @default
            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
    @endswitch
">
    {{ $text ?? ucfirst($status) }}
</span>
