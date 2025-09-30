@extends('layouts.mystyle')
@section('content')

<x-app-layout>
        <div class="flex flex-col items-center w-full overflow-hidden">

            <div class="w-full py-12">
                <div class="w-full">
                      <!-- Header -->
                    <div class="border-b bg-gradient-to-r from-orange-500/10 to-red-500/10 border-gray-700/50 backdrop-blur-sm">
    <div class="px-4 py-6 sm:px-6 md:px-8 lg:px-12">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-4xl font-black md:text-5xl lg:text-6xl">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-orange-100 to-orange-300">
                        Admin
                    </span>
                    <span class="block mt-2 text-2xl font-bold text-orange-400 md:text-3xl lg:text-4xl">
                        Dashboard
                    </span>
                </h1>
                <div class="w-20 h-1 mt-4 bg-gradient-to-r from-orange-400 to-red-400"></div>
            </div>

            <!-- Admin Role Display -->
            <div class="text-right">
                <p class="text-sm text-gray-300">Admin Dashboard</p>
                <p class="text-xl font-bold {{ $roleColorClass ?? '' }}">
                    {{ ucfirst($userRole ?? 'Admin') }} Access
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->

<div class="px-4 py-6 sm:px-6 md:px-8 lg:px-12">
     <div class="flex flex-wrap gap-2">
    @foreach ($tabs as $tab)
        <a href="{{ $tab['url'] }}"
           class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2
           {{ ($activeTab ?? 'overview') === $tab['id'] ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg'
              : 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
            {!! $tab['icon'] !!}
            {{ $tab['name'] }}
        </a>
    @endforeach
    </div>
</div>

<!-- Content Area -->
<div class="px-4 pb-12 sm:px-6 md:px-8 lg:px-12">
    @if (($activeTab ?? 'overview') === 'overview')
        <!-- Dashboard Stats -->
        @if ($loading ?? false)
            <div class="py-12 text-center">
                <div class="inline-block w-8 h-8 border-4 rounded-full border-orange-500/30 border-t-orange-500 animate-spin"></div>
                <p class="mt-4 text-gray-400">Loading dashboard...</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($stats ?? [] as $stat)
                    <div class="p-6 transition-transform duration-300 border border-gray-700 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-400">{{ $stat['title'] }}</p>
                                <p class="mt-2 text-3xl font-bold text-white">{{ $stat['value'] }}</p>
                            </div>
                            <div class="p-3 rounded-xl {{ $stat['bgColor'] }}">
                                {!! $stat['icon'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Recent Registrations -->
            @if (!empty($dashboardData['recent_registrations']))
                <div class="p-6 border border-gray-700 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl">
                    <h3 class="flex items-center gap-2 mb-4 text-xl font-bold text-white">
                        <!-- Icon -->
                        <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Recent Registrations
                    </h3>
                    <div class="space-y-3">
                        @foreach ($dashboardData['recent_registrations'] as $registration)
                            <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-red-400">
                                        <span class="text-sm font-bold text-white">
                                            {{ strtoupper(substr($registration['user']['info']['firstname'] ?? $registration['user']['email'], 0, 1)) }}
                                            {{ strtoupper(substr($registration['user']['info']['lastname'] ?? '', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">
                                            {{ $registration['user']['info']['firstname'] ?? '' }}
                                            {{ $registration['user']['info']['lastname'] ?? $registration['user']['email'] }}
                                        </p>
                                        <p class="text-sm text-gray-400">{{ $registration['event']['title'] ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-green-400">Registered</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($registration['created_at'])->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    @endif

    <!-- Qui puoi includere gli altri tab come componenti Blade -->
    @includeWhen(($activeTab ?? '') === 'events', 'admin.tabs.events')
    @includeWhen(($activeTab ?? '') === 'attendance', 'admin.tabs.attendance')
    @includeWhen(($activeTab ?? '') === 'categories', 'admin.tabs.categories')
    @includeWhen(($activeTab ?? '') === 'users', 'admin.tabs.users')
    @includeWhen(($activeTab ?? '') === 'registrations', 'admin.tabs.registrations')
    @includeWhen(($activeTab ?? '') === 'partners', 'admin.tabs.partners')
</div>

                </div>
            </div>
        </div>
    </x-app-layout>
@endsection