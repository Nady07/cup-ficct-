@props(['class' => ''])

<td {{ $attributes->merge(['class' => 'px-3 py-2 text-xs ' . $class]) }}>
    {{ $slot }}
</td>