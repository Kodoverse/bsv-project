@props(['widgets' => []])

@php
    $count = count($widgets);
    $cols = $count <= 2 ? 'grid-cols-1 sm:grid-cols-2' : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
@endphp

<div  {{ $attributes->merge(['class' => "lg:grid gap-4 $cols mb-6 px-8 hidden"]) }}>
    @foreach ($widgets as $widget)
        <x-widget-stats 
            :label="$widget['label'] ?? ''" 
            :value="$widget['value'] ?? ''"
            :icon="$widget['icon'] ?? null"
            :variant="$widget['variant'] ?? 'default'" />
    @endforeach
</div>