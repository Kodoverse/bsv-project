<x-admin-layout>
    <div class="flex flex-col items-center w-full overflow-hidden bg-background">
        <div class="w-full py-6">
            <div class="w-full">
                <!-- Header -->
                <div class="mx-3 bg-background rounded-2xl">
                    <div class="px-6 py-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h1 class="text-4xl font-black md:text-4xl lg:text-4xl">
                                    <span class="text-transparent">
                                        <span class="shine-text">{{ $messageText }}</span>
                                    </span>
                                    <span class="emoji">{{ $messageEmoji }}</span>
                                </h1>
                                <span class="mt-2 text-2xl font-bold text-foreground md:text-2xl lg:text-2xl">
                                    Hai 6 nuove Notifiche
                                </span>
                                <div class="w-20 h-1 mt-4 dark:bg-white shine-text"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="p-6 bg-background">
                    <div class="grid gap-6 xl:grid-cols-12">
                        <!-- COLONNA SINISTRA (5/12) -->
                        <div class="flex flex-col gap-6 xl:col-span-5">
                            <!-- Riepilogo Attività -->
                            <section class="p-6 text-gray-100 rounded shadow bg-surface">
                                <h2 class="mb-4 text-lg font-semibold text-foreground">Riepilogo Attività</h2>
                                <x-widget-group :widgets="[
                                    ['label' => 'Eventi Tano', 'value' => 27, 'variant' => 'accent'],
                                    ['label' => 'Categoria Di Ballo', 'value' => 'Cultura', 'variant' => 'default'],
                                    ['label' => 'Partecipazioni Mensili', 'value' => 46, 'variant' => 'success'],
                                    ['label' => 'Rewards Totali', 'value' => 386, 'variant' => 'warning'],
                                ]" />
                            </section>

                            <!-- Riepilogo visite -->
                            <section class="flex-1 p-6 text-gray-100 bg-gray-800 shadow rounded-2xl bg-surface">
                                <h2 class="mb-4 text-lg font-semibold">Riepilogo visite 2025</h2>
                                <div class="flex items-center justify-center h-64 text-gray-400">[Grafico]</div>
                            </section>
                        </div>

                        <!-- COLONNA DESTRA (7/12) -->
                        <div class="flex flex-col gap-6 xl:col-span-7">
                            <!-- Eventi in programma -->
                            <section class="p-6 text-gray-100 bg-gray-800 shadow rounded-2xl bg-surface">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold">Ultimi Eventi in programma</h2>
                                    <a href="#" class="text-sm text-gray-400 hover:text-gray-200">Mostra tutti</a>
                                </div>
                                <!-- Header -->
                                <div class="grid grid-cols-6 pb-2 text-sm text-center text-gray-400 border-gray-700">
                                    <div>Nome</div>
                                    <div class="sm:hidden md:block">Categoria</div>
                                    <div>Data</div>
                                    <div>Orario</div>
                                    <div>Partecipanti</div>
                                    <div></div>
                                </div>

                                <!-- Righe -->
                                <div class="space-y-2 text-sm bg-surface">
                                    <div
                                        class="grid items-center grid-cols-6 p-3 text-center bg-gray-700/60 rounded-xl">
                                        <div>Evento 1</div>
                                        <div>Volontariato</div>
                                        <div>20 ottobre 2025</div>
                                        <div>16:00</div>
                                        <div>13</div>
                                        <div><a href="">Mostra Evento<span></span></a></div>
                                    </div>
                                    <div
                                        class="grid items-center grid-cols-6 p-3 text-center bg-gray-700/60 rounded-xl">
                                        <div>Evento 2</div>
                                        <div>Cinema Night</div>
                                        <div>23 ottobre 2025</div>
                                        <div>20:30</div>
                                        <div>4</div>
                                        <div><a href="">Mostra Evento<span></span></a></div>
                                    </div>
                                    <div
                                        class="grid items-center grid-cols-6 p-3 text-center bg-gray-700/60 rounded-xl">
                                        <div>Evento 3</div>
                                        <div>Gaming</div>
                                        <div>28 ottobre 2025</div>
                                        <div>15:00</div>
                                        <div>11</div>
                                        <div><a href="">Mostra Evento<span></span></a></div>
                                    </div>
                                    <div
                                        class="grid items-center grid-cols-6 p-3 text-center bg-gray-700/60 rounded-xl">
                                        <div>Evento 3</div>
                                        <div>Gaming</div>
                                        <div>28 ottobre 2025</div>
                                        <div>15:00</div>
                                        <div>11</div>
                                        <div><a href="">Mostra Evento<span></span></a></div>
                                    </div>
                                    <div
                                        class="grid items-center grid-cols-6 p-3 text-center bg-gray-700/60 rounded-xl">
                                        <div>Evento 3</div>
                                        <div>Gaming</div>
                                        <div>28 ottobre 2025</div>
                                        <div>15:00</div>
                                        <div>11</div>
                                        <div><a href="">Mostra Evento<span></span></a></div>
                                    </div>

                                </div>

                            </section>

                            <!-- Ultimi redeem -->
                            <section class="flex-1 p-6 text-gray-100 shadow bg-surface rounded-xl">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold">Ultimi redeem</h2>
                                    <a href="#" class="text-sm text-gray-400 hover:text-gray-200">Mostra tutti</a>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between p-3 bg-gray-700 rounded-xl">
                                        <span>Mario Rossi</span><span>Caffè</span><span>10 ott</span>
                                    </div>
                                    <div class="flex justify-between p-3 bg-gray-700 rounded-xl">
                                        <span>Mario Rossi</span><span>Caffè</span><span>Bar Nazionale</span><span>10
                                            ott</span>
                                    </div>
                                    <div class="flex justify-between p-3 bg-gray-700 rounded-xl">
                                        <span>Jack94</span><span>Voucher</span><span>7 ott</span>
                                    </div>
                                    <div class="flex justify-between p-3 bg-gray-700 rounded-xl">
                                        <span>Jack94</span><span>Voucher</span><span>7 ott</span>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>


                {{-- <!-- Content Area -->
                    <div class="flex h-96">
                        <div class="px-4 pb-6 my-12 lg:w-1/2 sm:px-6 md:px-8 lg:px-12">
                            <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                                @foreach ($stats ?? [] as $stat)
                                    <div
                                        class="p-6 transition-transform duration-300 border border-gray-700 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl hover:scale-105">
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
                        </div>
                        <div
                            class="px-4 py-6 my-12 overflow-hidden border border-gray-700 lg:w-1/2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl">
                            <h3 class="flex items-center px-3 mb-4 text-xl font-bold text-white">
                                <!-- Icon -->
                                <span class="mr-2">
                                <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                </span>
                                Recent Registrations
                            </h3>
                            <div class="space-y-3">
                                @foreach ($dashboardData['recent_registrations'] as $registration)
                                    <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-red-400">
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
                                                <p class="text-sm text-gray-400">
                                                    {{ $registration['event']['title'] ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-green-400">Registered</p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($registration['created_at'])->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --}}
            </div>
        </div>
    </div>
</x-admin-layout>

<style>
    @keyframes shine {
        0% {
            background-position: -200%;
        }

        100% {
            background-position: 200%;
        }
    }

    .shine-text {
        background-image: linear-gradient(90deg,
                #b8860b 0%,
                #c9ac07 25%,
                #cac2a3 50%,
                #ffd700 75%,
                #b8860b 100%);
        background-size: 200%;
        animation: shine 10s linear infinite;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
