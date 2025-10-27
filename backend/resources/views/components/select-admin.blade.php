@props([
    'options' => [],
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'label' => ' ',
    'value' => null,
])

<div class="flex flex-col"><label for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}"
        {{ $attributes->merge(['class' => 'rounded rounded-2 border-1 cursor-text p-3 ']) }}>
        @if (isset($placeholder))
        <option value="" disabled {{ !$value ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif
        @foreach ($options as $option)
            <option value="{{ $option->id }}"
                {{ (string) $option->id === (string) $value ? 'selected' : '' }}>
                {{ $option->name }}</option>
        @endforeach
    </select>
</div>
