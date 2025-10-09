<?php
$sidebarLinks = [
    [
        'route' => 'partner.dashboard',
        'label' => 'Dashboard',
        'icon' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0l6-6m-6-6l-2-2"></path>
                   </svg>',
    ],
    [
        'route' => 'partner.notifiche',
        'label' => 'Notifiche',
        'icon' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                   </svg>',
    ],
    [
        'route' => 'partner.profilo',
        'label' => 'Profilo',
        'icon' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M12 12a4 4 0 100-8 4 4 0 000 8z"></path>
                   </svg>',
    ],
    [
        'route' => 'partner.impostazioni',
        'label' => 'Impostazioni',
        'icon' => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zM12 2v2m0 16v2m8-10h2M2 12H0m15.364-6.364l1.414 1.414M4.222 19.778l1.414-1.414M19.778 19.778l-1.414-1.414M4.222 4.222l1.414 1.414"></path>
                   </svg>',
    ],
];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-full font-sans antialiased">
    <div class="text-white-900 ">
        <!-- drawer component -->
        <div id="drawer-right-example"
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <div class="h-1/2">
                <h5 id="drawer-right-label"
                    class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg
                        class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>Right drawer</h5>
                <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
                <!-- Sidebar Links -->
                <div class="flex flex-col p-4 bg-gray-800 h-full">
                    @foreach ($sidebarLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="flex items-center p-2 mb-3 rounded-md bg-gray-800 text-white
                              {{ request()->routeIs($link['route']) ? 'border-l-4 bg-gray-600 border-gray-300 text-gray-300' : 'hover:bg-gray-700' }}">
                            {!! $link['icon'] !!}
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <!-- Dropdown menu
            <div id="dropdownTags"
                class="hidden w-56 mb-3 space-y-2 bg-gray-900 divide-y divide-gray-100 rounded-lg shadow-md">
                <ul class="py-2 font-semibold text-white text-md" aria-labelledby="dropdownBottomButton">
                    <li>
                        <x-dropdown-link :href="route('tags.create')">
                            {{ __('Add Tags') }}
                        </x-dropdown-link>
                    </li>
                    <li>
                        <x-dropdown-link :href="route('tags.index')">
                            {{ __('View Tags') }}
                        </x-dropdown-link>
                    </li>

                </ul>
            </div> -->
<!-- logout -->
            <div class="h-1/2  flex items-end">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf

                    <a class="block w-full p-2 text-center bg-red-400 rounded-md hover:bg-red-600 hover:font-semibold"
                        :href="route('logout')" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
        <main class="flex-1 w-full overflow-y-auto text-white bg-white dark:bg-gray-800">
            <div class="flex justify-between p-2">
                <div>
                    <img class="h-10 w-15" src="{{ asset('images/biblioteca_logo.png') }}" alt="">
                </div>
                <button
                    class="text-white bg-gary-500 hover:bg-gray-800 focus:ring-4 focus:ring-violet-200 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-500 focus:outline-none dark:focus:ring-blue-800"
                    type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                    data-drawer-placement="right" aria-controls="drawer-right-example">
                    Menù
                </button>
            </div>
            @yield('content')
        </main>
</body>
</html>