<!-- Bottone hamburger - visibile solo su md e sotto -->
<!-- Bottone hamburger - solo mobile -->

<aside 
    x-data
    x-init="$store.sidebar.init()"
    x-show="$store.sidebar.visible"
    x-transition:enter="transition transform duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition transform duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 z-40 flex flex-col w-64 h-screen min-w-20 bg-sidebar text-foreground lg:relative lg:flex shadow-card-light dark:shadow-card-dark"
    :class="$store.sidebar.open ? 'w-64' : 'w-14'"
>
    {{-- Toggle --}}
    {{-- <button @click="$store.sidebar.toggleMain()"
        class="hidden text-white transition-all duration-300 bg-accent-red hover:bg-accent-orange rounded-md shadow-md lg:flex lg:absolute items-center justify-center -right-3.5 top-5">
        <i :class="$store.sidebar.open ? 'fa fa-arrow-left' : 'fa fa-arrow-right'" class="w-4 text-center text-white align-middle"
            aria-hidden="true"></i>
    </button> --}}


    <div class="flex items-center justify-center py-4 lg:py-2 logo h-1/6">
        <img src="{{ asset('images/biblioteca_logo.png') }}" class="transition-all duration-300"
            :class="$store.sidebar.open ? 'w-20' : 'w-10'">
    </div>

    <div id="user-info" class="flex flex-col items-center w-full gap-5 h-1/6">
        <div class="flex items-center justify-center text-white transition-all duration-300 rounded-full bg-accent-orange/80 shadow-btn-light dark:shadow-btn-dark-orange" :class="$store.sidebar.open ? 'w-24 h-24' : 'w-12 h-12'">
            <p class="transition-all duration-300 text-foreground" :class="$store.sidebar.open ? 'text-3xl' : 'text-xl'">{{ $user->initials }}</p>
        </div>
        <div class="flex flex-col items-center gap-1" :class="$store.sidebar.open ? '' : 'hidden w-0'">
            <p><span>{{ $user->info->firstname}}</span> <span> {{  $user->info->lastname }}</span></p>
            <p class="text-xs font-bold capitalize text-accent-red">{{$user->user_role}}</p>
        </div>
    </div>





    {{-- <button data-collapse-toggle="navbar-default" type="button"
        class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg bg:white md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 1h15M1 7h15M1 13h15" />
        </svg>
    </button> --}}

    {{-- Menu --}}
<nav class="mt-12 space-y-1 h-4/6">
    @foreach ($sidebarItems as $item)
        <div x-data="{ open: false }" class="overflow-hidden transition-all duration-300 ease-in-out">
            <!-- Voce principale -->
<a href="{{ $item->route ? route($item->route) : '#' }}"
   class="flex items-center justify-start px-2 rounded-md text-md transition-all duration-300
          hover:text-accent-orange focus:text-accent-orange
          focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#F28A4A]/60
          dark:focus-visible:ring-[#F4975B]/50
          hover:bg-accent-red/10 dark:hover:bg-accent-orange/10"
   :class="$store.sidebar.open ? '' : 'justify-center'"
@click="$store.sidebar.toggle({{ $item->id }})">

    {{-- Icona principale --}}
    <div class="flex items-center justify-center w-10 h-10">
        <i class="px-2 transition-transform duration-300 {{ $item->icon }}"
           :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
    </div>

    {{-- Etichetta --}}
    <span class="inline-block ml-2 overflow-hidden transition-all duration-300 origin-left whitespace-nowrap"
          :class="$store.sidebar.open ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
        {{ $item->label }}
    </span>

    {{-- Freccia sottomenù --}}
    @if ($item->children->count())
        <span class="inline-flex items-center ml-auto" x-show="$store.sidebar.open">
            <i class="inline-block transition-transform duration-300 transform-gpu fa fa-caret-right"
               :class="$store.sidebar.openId === {{ $item->id }} ? 'rotate-90 text-[#F28A4A]' : 'rotate-0 text-zinc-400'">
            </i>
        </span>
    @endif
</a>


            <!-- Sottovoci con transizione -->
            @if ($item->children->count())
                <ul x-show="$store.sidebar.openId === {{ $item->id }}"
                    x-transition:enter="transition-all ease-out duration-300"
                    x-transition:enter-start="max-h-0 opacity-0"
                    x-transition:enter-end="max-h-56 opacity-100"
                    x-transition:leave="transition-all ease-in duration-300"
                    x-transition:leave-start="max-h-56 opacity-100"
                    x-transition:leave-end="max-h-0 opacity-0"
                    class="mt-1 ml-10 space-y-1 overflow-hidden">
                    @foreach ($item->children as $child)
                        <li>
                            <a href="{{ $child->route ? route($child->route) : '#' }}"
                                class="block px-4 py-2 text-sm transition-all rounded text-foreground/70 hover:bg-accent-orange/10 hover:text-accent-orange">
                                {{ $child->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</nav>
<form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden"> 
    @csrf 
</form> 
<div class="justify-end mt-auto mb-6 transition-all duration-300"> 
   <a 
            href="#" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center justify-start px-4 py-2 text-base transition-all duration-300 rounded-md hover:bg-accent-red/10 text-foreground group"
            :class="$store.sidebar.open ? '' : 'justify-center'"
        >
        <div class="flex items-center justify-center w-10 h-10">
                <svg class="w-6 h-6 transition-colors duration-200 group-hover:text-accent-red dark:group-hover:text-accent-orange" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0l-4-4m4 4l-4 4" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19V5a2 2 0 00-2-2h-7" />
                </svg>
            </div>
        <span 
                class="ml-2 transition-transform duration-300 origin-left group-hover:text-accent-red dark:group-hover:text-accent-orange"
                :class="$store.sidebar.open ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
                {{ __('Log Out') }}
            </span>
    </a> 
</div>


</aside>

<style>
    aside{
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px 
    }
</style>