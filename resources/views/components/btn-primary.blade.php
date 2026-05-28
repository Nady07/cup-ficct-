@props(['route'])

<a href="{{ $route }}" {{ $attributes->merge(['class' => 'btn-primary inline-flex items-center gap-1.5 text-sm']) }}>
    {{ $slot }}
</a>