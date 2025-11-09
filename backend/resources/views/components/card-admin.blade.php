@props([
    'title' => null,
    'href' => null,
    'image' => null,
    'isSubcategory' => false,
])

@php
    // Classi dinamiche base
    $baseClasses = 'aspect-square flex flex-col justify-center items-center p-6 rounded-2xl 
                    border shadow-sm transition-all duration-300 hover:scale-105 group';

    // Stile condizionale in base al tipo
    $typeClasses = $isSubcategory
        ? 'bg-[#E65C4F]/5 border-[#E65C4F]/30 hover:border-[#E65C4F]/60'
        : 'bg-background border-border hover:border-[#E65C4F]/40';
@endphp

{{-- Se ha href → card cliccabile --}}
@if ($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => "$baseClasses $typeClasses"]) }}>
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}"
                 class="object-cover w-24 h-24 mb-4 rounded-full shadow-sm">
        @endif

        <h3 class="text-lg font-semibold text-center text-foreground group-hover:text-[#E65C4F]">
            {{ $title }}
        </h3>
    </a>
@else
    {{-- Se non ha href → div statico --}}
    <div {{ $attributes->merge(['class' => "$baseClasses $typeClasses"]) }}>
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}"
                 class="object-cover w-24 h-24 mb-4 rounded-full shadow-sm">
        @endif

        <h3 class="text-lg font-semibold text-center text-foreground group-hover:text-[#E65C4F]">
            {{ $title }}
        </h3>
    </div>
@endif
