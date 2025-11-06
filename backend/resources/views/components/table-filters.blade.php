@props([
    'searchPlaceholder' => 'Cerca...',
    'action' => null, // opzionale, se non passa niente prende l'URL corrente
])

<form method="GET" action="{{ $action ?? url()->current() }}" class="flex flex-wrap items-center gap-3">
    {{-- 🔍 Campo ricerca base --}}
    <div class="relative">
        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ $searchPlaceholder }}"
            class="block w-64 p-2.5 pl-10 text-sm rounded-lg
                   bg-white/80 dark:bg-[#23252B] text-foreground
                   border border-[#E8E3DD]/70 dark:border-[#2B2C31]/70
                   focus:ring-2 focus:ring-[#E65C4F]/40 focus:border-[#E65C4F]
                   placeholder:text-muted transition-all" />
        <i class="absolute left-3 top-3.5 text-zinc-400 fa fa-search"></i>
    </div>

    {{-- 🎛 Slot per altri filtri personalizzati (select, checkbox, ecc.) --}}
    {{ $slot }}

    {{-- 🎯 Pulsanti --}}
    <div class="flex items-center gap-2">
        <button type="submit" 
            class="px-8 py-3 flex items-center text-sm justify-center text-foreground rounded-lg bg-white hover:bg-[#d44e41]">
            <div>Applica</div>
        </button>

        <a href="{{ $action ?? url()->current() }}"
           class="text-sm underline text-muted-foreground hover:text-foreground">
           Resetta Filtri
        </a>
    </div>
</form>
