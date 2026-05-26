@props(['label', 'value', 'icon' => null, 'color' => 'ficct-blue'])

<div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">{{ $label }}</p>
            <p class="text-3xl font-bold text-{{ $color }} dark:text-ficct-gold">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="w-12 h-12 bg-{{ $color }} bg-opacity-10 dark:bg-opacity-20 rounded-lg flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
