<button
    x-data="{ dark: localStorage.getItem('theme') === 'dark', hover: false }"
    x-init="
        if (dark) document.documentElement.classList.add('dark');
    "
    @click="
        dark = !dark;
        if (dark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    "
    @mouseenter="hover = true"
    @mouseleave="hover = false"
    aria-label="Toggle dark mode"
    class="relative flex items-center p-4 overflow-hidden transition-all duration-300 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 "
    :class="hover && window.innerWidth >= 1024 ? 'w-40 pl-4 pr-4' : 'w-5 h-5 justify-center'"
>
    <template x-if="!dark">
        <i class="text-xl text-foreground fa-solid fa-moon"></i>
    </template>
    <template x-if="dark">
        <i class="text-xl text-foreground fa-solid fa-sun"></i>
    </template>

    <!-- Testo visibile solo al hover -->
    <span
        x-show="hover"
        x-transition:enter.duration.300ms
        x-transition:leave.duration.200ms
        class="hidden ml-3 text-sm text-foreground lg:block whitespace-nowrap dark:text-gray-200"
        x-text="dark ? 'Modalità chiara' : 'Modalità scura'"
    ></span>
</button>

<style>
    button{
        align-self: center;
        width: 20px;
        height: 20px;
    }
</style>
