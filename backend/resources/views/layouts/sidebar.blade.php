<!-- Sidebar -->
    <div class="flex flex-col w-full h-full text-white transition-all duration-300 bg-gray-900"
        :class="$store.sidebar.open ? 'w-72' : 'w-20'">
        <!-- Bottone toggle -->
        <button @click="$store.sidebar.open = !$store.sidebar.open"
            class="absolute p-2 text-white transition-all duration-300 bg-gray-600 rounded-full shadow-md -left-1 top-4">
            <i :class="$store.sidebar.open ? 'fa fa-lock-open' : 'fa fa-lock'" class="w-10" aria-hidden="true"></i>
        </button>
        <div class="flex items-center justify-center p-4 logo">
            <img src="{{ asset('images/biblioteca_logo.png') }}"
                class="transition-all duration-300"
                :class="open ? 'w-40' : 'w-28'">
        </div>
        <!-- Menu -->
        <nav class="mt-12 space-y-2">
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="transition-all duration-300 fa fa-home" aria-hidden="true"
                     :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Home
                </span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-calendar" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Eventi
                </span>
                            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-calendar-days" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Partecipazioni
                </span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-users" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Utenti
                </span>
                            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-edit" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    News e Comunicazioni
                </span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-bell" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Notifiche
                </span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-shop" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Partner
                </span>
                <span x-show="open" class="transition-opacity duration-300">Partner</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 space-x-2 text-2xl hover:bg-gray-700">
                <i class="fa fa-gear" aria-hidden="true" :class="$store.sidebar.open ? 'scale-100' : 'w-100'"></i>
                <span class="inline-block transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    Impostazioni
                </span>
            </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
    
                <a class="block w-full p-2 rounded-md hover:bg-red-500 hover:font-semibold" :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </nav>
    </div>
