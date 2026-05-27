@props(['items' => []])

<nav class="flex items-center space-x-2 mb-6 text-sm">
    <a href="{{ route('admin.dashboard') }}" class="text-ficct-blue dark:text-ficct-gold hover:underline font-medium">
        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        Dashboard
    </a>

    @foreach($items as $item)
        <span class="text-gray-400 dark:text-gray-600">/</span>
        @if($loop->last)
            <span class="text-gray-600 dark:text-gray-400 font-semibold">{{ $item['label'] }}</span>
        @else
            <a href="{{ $item['url'] ?? '#' }}" class="text-ficct-blue dark:text-ficct-gold hover:underline">
                {{ $item['label'] }}
            </a>
        @endif
    @endforeach
</nav>

{{ $slot }}
