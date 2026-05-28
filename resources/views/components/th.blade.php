@props(['class' => ''])

<th {{ $attributes->merge(['class' => 'px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide whitespace-nowrap ' . $class]) }}>
    {{ $slot }}
</th>