<div x-data="{ open: false }" class="relative">
    <!-- Bottone notifiche -->
    <button 
        @click="open = !open"
        class="relative flex items-center justify-center w-10 h-10 text-gray-700 transition-colors rounded-full dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
        aria-label="Notifiche"
    >
        <i class="text-xl text-black fa-solid fa-bell dark:text-white"></i>

        <!-- Badge notifiche -->
        <span class="absolute w-2 h-2 bg-red-500 rounded-full top-1 right-1"></span>
    </button>

    <!-- Menu notifiche -->
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition.origin.top.right
        class="absolute right-0 z-20 w-64 mt-2 overflow-hidden transition-all bg-white border rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700"
    >
        <!-- Per ora vuoto -->
        <div class="p-4 text-sm text-gray-700 dark:text-gray-200">
            Nessuna notifica
        </div>
    </div>
</div>