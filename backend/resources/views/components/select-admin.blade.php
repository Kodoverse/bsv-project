@props([
'options' => [],
'id' => null,
'name' =>null,
'placeholder' => null,
])

<div class="flex flex-col"><label for="{{ $id }}">Categoria Evento</label>
<select name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'rounded rounded-2 border-1 cursor-text p-3 ',]) }}>
    @if(isset($placeholder))
        <option value="" selected disabled>{{ $placeholder }}</option>
    @endif
    @foreach ($options as $key => $option )
    <option value="{{ $key }}">
        @if(isset($selected) && $selected == ($option->id)) selected @endif
        {{ $option->name }}</option>
    @endforeach
</select></div>