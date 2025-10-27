@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'name' => '',
    'messages' =>null,
    'value' => null,
])

<div {{ $attributes->class(['flex flex-col']) }}>
    <label for="{{ $id }}"
        class="">
        {{ $label }}
    </label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" autocomplete="off" value="{{ old($name, is_array($value) ? '' : ($value ?? '')) }}"
        {{ $attributes->merge([
            'class' => 'rounded rounded-2 border-1 cursor-text p-3 ',
        ]) }} />
    <x-input-error :messages="$errors->get($name)" class=""/>

</div>


<style>
</style>
