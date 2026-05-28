@props(['color' => 'gray'])

@php
    $colors = [
        'green'  => 'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300',
        'red'    => 'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300',
        'yellow' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300',
        'blue'   => 'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
        'purple' => 'bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300',
        'gray'   => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex px-1.5 py-0.5 rounded text-[10px] font-medium ' . ($colors[$color] ?? $colors['gray'])]) }}>
    {{ $slot }}
</span>