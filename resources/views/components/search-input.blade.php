@props(['placeholder' => 'Buscar...', 'value' => '', 'name' => 'buscar'])

<div class="relative flex-1 min-w-[180px]">
    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
           class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all"
           @input.debounce.300ms="$el.form.requestSubmit()">
</div>