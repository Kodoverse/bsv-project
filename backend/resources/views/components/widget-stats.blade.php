@props([
    'label' => '',
    'value' => '',
    'icon' => null,
    'variant' => 'default'
])
@php
$variants = [
    'default' => 'bg-card text-foreground border-border',
    'accent' => 'bg-coral/10 text-coral border-coral/20',
    'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
];
@endphp


<div {{ $attributes->merge(['class' => "flex flex-col items-center justify-center p-5 rounded-2xl shadow-sm border text-center transition-all hover:shadow-md ".$variants[$variant]]) }}>
    <span class="text-sm text-muted-foreground">{{ $label }}</span>
    <span class="mt-1 text-2xl font-semibold">{{ $value }}</span>
</div>