@extends('layouts.partner')
@section('content')

    <div class="flex flex-col items-center w-full overflow-hidden">

        <div class="w-full ">
            <div class="w-full">
                <!-- Header -->
                <div
                    class="border-b bg-gradient-to-r from-violet-500/10 to-gray-500/10 border-blue-700/50 backdrop-blur-sm">
                    <div class="px-4 py-6 sm:px-6 md:px-8 lg:px-12">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h1 class="text-4xl font-black md:text-5xl lg:text-6xl">
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-blue-200 to-violet-300">
                                        Ciao {{ $user->info->firstname }}
                                    </span>

                                </h1>
                                <div class="w-20 h-1 mt-4 bg-gradient-to-r from-violet-400 to-blue-400"></div>
                            </div>

                            <!-- Partner Role Display -->
                            <div class="text-right">
                                <p class="text-xl font-bold {{ $roleColorClass ?? '' }}">
                                    {{ ucfirst($userRole ?? 'Partner') }}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- Navigation Tabs -->

                <div class="px-4 py-6 sm:px-6 md:px-8 lg:px-12">
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tabs as $tab)
                                        <a href="{{ $tab['url'] }}" class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2
                                                                                               {{ ($activeTab ?? 'overview') === $tab['id'] ? 'bg-gradient-to-r from-violet-500 to-blue-400 text-white shadow-lg'
                            : 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                                            {!! $tab['icon'] !!}
                                            {{ $tab['name'] }}
                                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="px-4 pb-12 sm:px-6 md:px-8 lg:px-12">
                 

                    <!-- Qui puoi includere gli altri tab come componenti Blade -->
                    @includeWhen(($activeTab ?? '') === 'overview', 'partner.tabs.overview')
                    @includeWhen(($activeTab ?? '') === 'products', 'partner.tabs.products')
                    @includeWhen(($activeTab ?? '') === 'sales', 'partner.tabs.sales')
                    @includeWhen(($activeTab ?? '') === 'redemptions', 'partner.tabs.redemptions')
                    @includeWhen(($activeTab ?? '') === 'profile', 'partner.tabs.profile')

                </div>

            </div>
        </div>
    </div>

@endsection