@props([
    'action' => '#',
    'method' => 'POST',
    'title' => null,
    'submitLabel' => 'Salva'
])

<form action="{{ $action }}" method="POST" {{ $attributes->merge(['class' => 'space-y-6']) }}>
@csrf
@if(in_array(strtoupper($method), ['PUT', 'DELETE', 'PATCH']))
    @method($method)
@endif

<div class="grid items-start grid-cols-1 gap-6 md:grid-cols-2">
    {{ $slot }}
</div>
</form>