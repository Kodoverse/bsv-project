@props([
    'placeholder' => 'Cerca...',
    'action' => '#',
])

<form action="{{ $action }}" class="w-2/3 max-w-xl mx-auto">
    <div class="relative flex items-center">
        <input
            type="search"
            id="default-search"
            placeholder="{{ $placeholder }}"
            class="block w-full py-3 pl-4 pr-12 text-sm text-foreground placeholder-muted
                bg-surface border border-[#E8E3DD] dark:border-[#2B2C31]
                rounded-xl shadow-sm
                hover:bg-[#FFF8F4] dark:hover:bg-[#1C1D22]
                focus:border-accent-red focus:ring-1 focus:ring-accent-red/50
                transition-all duration-200
                dark:bg-[#272930] dark:text-[#E5E7EB] dark:placeholder-[#999]"
        />

        <button type="submit"
            class="absolute flex items-center justify-center transition-all duration-200 rounded-full right-2 w-9 h-9 bg-accent-red hover:bg-accent-orange active:scale-95 shadow-btn-light dark:shadow-btn-dark-red"
            title="Cerca">
            <i class="fa fa-search text-white text-[15px]" aria-hidden="true"></i>
        </button>
    </div>
</form>