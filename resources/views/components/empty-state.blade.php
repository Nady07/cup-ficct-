@props(['message' => 'Sin registros', 'submessage' => null, 'cols' => 4])

<tr>
    <td colspan="{{ $cols }}" class="px-5 py-12 text-center">
        <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="font-medium text-sm">{{ $message }}</p>
            @if($submessage)
                <p class="text-xs mt-1">{{ $submessage }}</p>
            @endif
        </div>
    </td>
</tr>