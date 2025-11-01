@props([
    'searchPlaceholder' => 'Cerca...',
])

<div class="flex flex-wrap items-center gap-3">
    {{-- Campo ricerca --}}
    <div class="relative">
        <input
            type="search"
            placeholder="{{ $searchPlaceholder }}"
            class="block w-64 p-2.5 pl-10 text-sm rounded-lg
                   bg-white/80 dark:bg-[#23252B] text-foreground
                   border border-[#E8E3DD]/70 dark:border-[#2B2C31]/70
                   focus:ring-2 focus:ring-[#E65C4F]/40 focus:border-[#E65C4F]
                   placeholder:text-muted transition-all" />
        <i class="absolute left-3 top-3 text-zinc-400 fa fa-search"></i>
    </div>

    {{-- Slot per eventuali altri filtri --}}
    {{ $slot }}
</div>