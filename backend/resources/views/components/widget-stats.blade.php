@props([
    'label' => '',
    'value' => '',
    'icon' => null,
    'variant' => 'default',
])

@php
$variants = [
    'default' => 'bg-surface text-foreground border border-border shadow-sm hover:shadow-md',
    'accent' => 'bg-gradient-to-r from-[#F28A4A]/10 to-[#F4975B]/10 text-[#E65C4F] border border-[#E65C4F]/30',
    'success' => 'bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-200 dark:border-green-800/40',
    'warning' => 'bg-yellow-50 text-yellow-700 border border-yellow-300 dark:bg-yellow-900/30 dark:text-yellow-200 dark:border-yellow-800/40',
    'danger' => 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-200 dark:border-red-800/40',
];
$variant = (string)$variant;
@endphp

<div
    {{ $attributes->merge(['class' => "flex flex-col items-center justify-center p-6 rounded-2xl text-center transition-all duration-300 ".$variants[$variant]]) }}
>
    @if($icon)
        <div class="mb-2 text-2xl opacity-80">{!! $icon !!}</div>
    @endif

    <span class="text-sm font-medium text-muted-foreground">{{ $label }}</span>
    <span class="mt-1 text-3xl font-semibold text-foreground">{{ $value }}</span>
</div>