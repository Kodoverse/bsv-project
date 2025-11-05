@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<div
    class="flex items-center justify-between h-40 px-12 mb-6 rounded
    bg-gradient-to-r dark:bg-gradient-to-br from-[#E65C4F] via-[#F28A4A] to-[#F8C145]
    dark:from-[#8B3A33] dark:via-[#A85F37] dark:to-[#B78B34]
    text-white shadow-md transition-colors duration-300">

    <div>
        <h1 class="text-4xl font-semibold">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-white/80">{{ $subtitle }}</p>
        @endif
    </div>

    <div>
        {{ $slot }}
    </div>
</div>
