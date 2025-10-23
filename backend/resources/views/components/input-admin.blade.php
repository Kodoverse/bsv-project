@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'name' => null,
    'messages' =>null
])

<div {{ $attributes->class(['flex flex-col']) }}>
    <label for="{{ $id }}"
        class="">
        {{ $label }}
    </label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" autocomplete="off"
        {{ $attributes->merge([
            'class' => 'rounded rounded-2 border-1 cursor-text p-3 ',
        ]) }} />
    <x-input-error :messages="$errors->get($name)" class=""/>

</div>


<style>
</style>
