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

<body class="w-full font-sans antialiased bg-background text-foreground">
    <div x-cloak x-data="{ open: true }" class="flex h-screen">

        <!-- Sidebar -->
        <div class="hidden h-screen transition-all duration-300 lg:flex" :class="$store.sidebar.open ? 'w-64' : 'w-20'">
            @include('layouts.sidebar')
        </div>

        <!-- Wrapper mobile -->
        <div class="fixed top-0 left-0 z-40 h-screen bg-sidebar lg:hidden" x-show="$store.sidebar.visible"
            x-transition:enter="transition transform duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition transform duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            @include('layouts.sidebar')
        </div>


        <!-- Main -->
        <main class="flex-1 overflow-y-auto transition-all duration-300">
              
                <x-upper-nav-component />
    
            @yield('content')
        </main>

    </div>

</body>

</html>


<style>
    main {
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
    }
</style>
