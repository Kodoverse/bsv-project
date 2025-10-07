{{-- <!-- Sidebar -->
<div class="relative flex flex-col w-full h-full p-5 text-white transition-all duration-300 bg-gray-600">
    <!-- Bottone toggle -->
    <button @click="$store.sidebar.open = !$store.sidebar.open"
        class="absolute p-2 text-white transition-all duration-300 bg-gray-600 rounded-full shadow-md -right-16 top-4">
        <i :class="$store.sidebar.open ? 'fa fa-lock-open' : 'fa fa-lock'" class="w-7" aria-hidden="true"></i>
    </button>
    <div class="flex items-center justify-center logo">
        <img src="{{ asset('images/biblioteca_logo.png') }}" class="transition-all duration-300"
            :class="$store.sidebar.open ? 'w-28' : 'w-28'">
    </div>
    <!-- Menu -->
    <nav class="mt-12 space-y-2">
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-home"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Home
            </span>
        </a>

        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-calendar"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Eventi
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-calendar-days"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Partecipazioni
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-users"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Utenti
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-edit"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Eventi
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-bell"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Notifiche
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-shop"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Partner
            </span>
        </a>
        <a href="#"
            class="flex items-center justify-start px-4 py-2 text-xl transition-all duration-300 rounded hover:bg-gray-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-gear"
                    :class="$store.sidebar.open ? 'scale-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                Impostazioni
            </span>
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center justify-start px-4 py-1 text-xl transition-all duration-300 rounded hover:bg-red-700">
            <div class="flex items-center justify-center w-10 h-10">
                <i class="transition-transform duration-300 fa fa-right-from-bracket" aria-hidden="true"
                    :class="$store.sidebar.open ? 'w-100' : 'scale-150'"></i>
            </div>
            <span class="inline-block ml-2 transition-transform duration-300 origin-left"
                :class="$store.sidebar.open ? 'scale-100' : 'scale-0'">
                {{ __('Log Out') }}
            </span>
        </a>
    </nav>
</div> --}}

@php
    use App\Models\SidebarItem;

    $role = auth()->user()->role ?? 'partner';
    $sidebarItems = SidebarItem::whereNull('parent_id')
        ->forRole($role)
        ->orderBy('order')
        ->get()
        ->map(function ($item) use ($role) {
            $item->children = $item->visibleChildren($role);
            return $item;
        });
@endphp

<aside 
    x-data 
    class="relative flex flex-col w-full h-full p-5 text-white transition-all duration-300 bg-gray-600"
>
    {{-- Toggle --}}
    <div class="relative flex items-center justify-end p-4">
<button @click="$store.sidebar.open = !$store.sidebar.open"
        class="absolute p-2 text-white transition-all duration-300 bg-gray-600 rounded-full shadow-md -right-16 top-4">
        <i :class="$store.sidebar.open ? 'fa fa-lock-open' : 'fa fa-lock'" class="w-7" aria-hidden="true"></i>
    </button>
    </div>

    {{-- Menu --}}
    <nav class="mt-6 space-y-1">
        @foreach($sidebarItems as $item)
            <div x-data="{ open: false }">
                <a 
                    href="{{ $item->route ? route($item->route) : '#' }}"
                    @click="open = !open"
                    class="flex items-center px-4 py-2 text-sm font-medium transition-colors rounded-md hover:bg-gray-700"
                >
                    @if($item->icon)
                        <i class="{{ $item->icon }} text-lg mr-3"></i>
                    @endif

                    <span 
                        class="flex-1 truncate" 
                        x-show="$store.sidebar.open"
                        x-transition
                    >
                        {{ $item->label }}
                    </span>

                    @if($item->children->count())
                        <i 
                            class="text-xs fa" 
                            :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"
                            x-show="$store.sidebar.open"
                        ></i>
                    @endif
                </a>

                {{-- Sottovoci --}}
                @if($item->children->count())
                    <ul 
                        x-show="open && $store.sidebar.open"
                        x-transition
                        class="ml-6 space-y-1"
                    >
                        @foreach($item->children as $child)
                            <li>
                                <a 
                                    href="{{ $child->route ? route($child->route) : '#' }}"
                                    class="block px-4 py-2 text-sm text-gray-300 transition-colors rounded-md hover:bg-gray-700"
                                >
                                    {{ $child->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </nav>
</aside>

