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

<aside x-data class="relative flex flex-col w-full h-full p-5 text-white transition-all duration-300 bg-gray-600">
    {{-- Toggle --}}
    <button @click="$store.sidebar.open = !$store.sidebar.open"
        class="absolute p-2 text-white transition-all duration-300 bg-gray-600 rounded-full shadow-md -right-16 top-4">
        <i :class="$store.sidebar.open ? 'fa fa-lock-open' : 'fa fa-lock'" class="w-7" aria-hidden="true"></i>
    </button>
    <div class="flex items-center justify-center logo">
        <img src="{{ asset('images/biblioteca_logo.png') }}" class="transition-all duration-300"
            :class="$store.sidebar.open ? 'w-28' : 'w-28'">
    </div>





    {{-- Menu --}}
    <nav class="mt-12 space-y-1">
        @foreach ($sidebarItems as $item)
            <div x-data="{ open: false }">
                <a href="{{ $item->route ? route($item->route) : '#' }}" @click="open = !open"
                    class="flex items-center justify-start px-4 py-1 transition-all duration-300 rounded text-md hover:bg-gray-700">
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
            </div>
        @endforeach
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
        <div x-data="{open: false}" class="pt-6 transition-all duration-300 logout-container ">
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
