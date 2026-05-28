@props(['name', 'options' => [], 'selected' => null, 'placeholder' => 'Seleccionar...'])

<select name="{{ $name }}" 
        class="text-xs border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-2.5 py-1.5 focus:ring-1 focus:ring-blue-500 transition-all"
        @change="$el.form.requestSubmit()">
    <option value="">{{ $placeholder }}</option>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ (string)$value === (string)$selected ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>