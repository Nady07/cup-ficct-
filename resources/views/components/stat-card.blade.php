@props(['title', 'value', 'color' => 'blue', 'subtitle' => null])

@php
    $styles = [
        'blue'   => 'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
        'green'  => 'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300',
        'red'    => 'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300',
        'indigo' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
        'purple' => 'bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300',
        'gray'   => 'bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
    ];
    $s = $styles[$color] ?? $styles['blue'];
@endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-3 sm:p-5">
    <div class="flex items-center justify-between gap-2">
        <div class="min-w-0 flex-1">
            <p class="text-[10px] sm:text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide truncate">{{ $title }}</p>
            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white mt-0.5 sm:mt-1">{{ $value }}</p>
            @if($subtitle)
                <p class="text-[10px] sm:text-xs text-gray-400 dark:text-gray-500 mt-0.5 sm:mt-1 truncate">{{ $subtitle }}</p>
            @endif
        </div>
        {{-- Icono: más pequeño en móvil, oculto en pantallas muy pequeñas --}}
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg {{ $s }} flex items-center justify-center flex-shrink-0">
            <div class="w-3.5 h-3.5 sm:w-5 sm:h-5">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>