@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'required' => false])

<div>
    @if($label)
        <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" 
           name="{{ $name }}" 
           value="{{ $value }}" 
           class="input-ficct text-xs" 
           {{ $required ? 'required' : '' }}
           {{ $attributes }}>
</div>