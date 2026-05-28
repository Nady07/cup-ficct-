@props(['route' => null, 'title' => '', 'color' => 'gray'])

@php
    $colors = [
        'blue'  => 'hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20',
        'red'   => 'hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20',
        'green' => 'hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20',
        'gray'  => 'hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800',
    ];
@endphp

@if($route)
    <a href="{{ $route }}" {{ $attributes->merge(['class' => 'p-1 text-gray-400 rounded ' . $colors[$color] . ' transition-colors', 'title' => $title]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => 'p-1 text-gray-400 rounded ' . $colors[$color] . ' transition-colors', 'title' => $title]) }}>
        {{ $slot }}
    </button>
@endif