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

    <div x-cloak x-data="{ open: true }" class="flex h-screen bg-white">

        <!-- Sidebar -->
        <div class="fixed top-0 left-0 z-40 h-screen text-white transition-all duration-300 bg-black md:static"
            :class="{
                'w-72': $store.sidebar.open,
                'w-0 md:w-28': !$store.sidebar.open
            }">
            @include('layouts.sidebar')
        </div>
        <div x-show="$store.sidebar.open && window.innerWidth < 768" @click="$store.sidebar.open = false"
            class="fixed inset-0 z-30 transition-opacity duration-300 bg-black bg-opacity-50 md:hidden"></div>

        <!-- Main -->
        <main class="flex-1 overflow-y-auto transition-all duration-300 bg-white dark:bg-black">
            @yield('content')
        </main>

    </div>

</body>

</html>
