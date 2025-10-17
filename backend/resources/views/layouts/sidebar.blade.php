@php
    use App\Models\SidebarItem;

    $role = auth()->user()->role ?? 'admin';
    $sidebarItems = SidebarItem::whereNull('parent_id')
        ->forRole($role)
        ->orderBy('order')
        ->get()
        ->map(function ($item) use ($role) {
            $item->children = $item->visibleChildren($role);
            return $item;
        });
@endphp

<aside x-data="{ open: false }"
    class="relative flex-col justify-start w-full h-screen gap-8 p-0 transition-all duration-300 lg:p-2 display-none bg-sidebar text-foreground lg:flex" id="navbar-default">

    {{-- Toggle --}}
    <button @click="$store.sidebar.open = !$store.sidebar.open"
        class="hidden text-white transition-all duration-300 rounded shadow-md lg:block lg:absolute -right-8 top-5">
        <i :class="$store.sidebar.open ? 'fa fa-lock-open' : 'fa fa-lock'" class="w-5 text-center align-middle"
            aria-hidden="true"></i>
    </button>

    <div class="flex items-center justify-center py-4 lg:py-2 logo">
        <img src="{{ asset('images/biblioteca_logo.png') }}" class="transition-all duration-300"
            :class="$store.sidebar.open ? 'w-20' : 'w-14'">
    </div>

    <div id="user-info" class="flex flex-col items-center w-full gap-5" >
        <div class="flex items-center justify-center transition-all duration-300 bg-red-400 rounded-full" :class="$store.sidebar.open ? 'w-24 h-24' : 'w-12 h-12'">
            <p class="text-foreground " :class="$store.sidebar.open ? 'text-3xl' : 'text-xl'">{{ $user->initials }}</p>
        </div>
        <div class="flex flex-col items-center gap-1 transition-all duration-300" :class="$store.sidebar.open ? '' : 'hidden w-0'">
            <p><span>{{ $user->info->firstname}}</span> <span> {{  $user->info->lastname }}</span></p>
            <p class="font-extrabold capitalize">{{$user->user_role}}</p>
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
    <nav class="mt-12 space-y-1">
        @foreach ($sidebarItems as $item)
                <a href="{{ $item->route ? route($item->route) : '#' }}" @click="open = !open"
                    class="flex items-center justify-start px-2 transition-all duration-300 rounded text-md hover:bg-gray-700">
                    <div class="flex items-center w-10 h-10 text-center">
                        <i class="px-2 transition-transform duration-300 {{ $item->icon }}"
                            :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
                    </div>

                    <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                        :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                        {{ $item->label }}
                    </span>

                    @if ($item->children->count())
                        <i class="ml-auto text-sm fa" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"
                            x-show="$store.sidebar.open"></i>
                    @endif
                </a>

                <!-- Sottovoci -->
                @if ($item->children->count())
                    <ul x-show="open && $store.sidebar.open" x-transition class="mt-1 ml-10 space-y-1">
                        @foreach ($item->children as $child)
                            <li>
                                <a href="{{ $child->route ? route($child->route) : '#' }}"
                                    class="block px-4 py-2 text-sm text-gray-300 transition-all rounded hover:bg-gray-700">
                                    {{ $child->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @endforeach
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
        <div class="pt-6 transition-all duration-300 logout-container ">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center justify-start px-4 py-1 text-lg transition-all duration-300 rounded hover:bg-red-700">
                <div class="flex items-center justify-center w-10 h-10">
                    <i class="transition-transform duration-300 fa fa-right-from-bracket" aria-hidden="true"
                        :class="$store.sidebar.open ? 'w-100' : 'scale-150'"></i>
                </div>
                <span class="ml-2 transition-transform duration-300 origin-left"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                    {{ __('Log Out') }}
                </span>
            </a>
        </div>
    </nav>
</aside>

<style>
    aside{
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px 
    }
</style>