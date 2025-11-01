<div class="flex items-center justify-between w-full gap-2 px-4 py-6 mx-auto border-b dark:border-none md:gap-0">
    <div class="flex">
            <button @click="$store.sidebar.visible = !$store.sidebar.visible"
                class="z-50 text-white rounded-md lg:hidden">
                <!-- Icona hamburger -->
                <svg x-show="!$store.sidebar.visible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" class="w-6 h-6 text-foreground">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <!-- Icona chiusura -->
                <svg x-show="$store.sidebar.visible" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-foreground">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
    </div>
    <div class="justify-center flex-shrink hidden md:flex grow">
        <x-searchbar class="flex grow-1" />
    </div>
    <div class="flex">
        <div class="flex items-center justify-end gap-3 me-5">
            <x-theme-toggle />
            <x-notification-button />
        </div>
    </div>
</div>
