<div class="space-y-6">
    <!-- Intestazione -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Profilo Aziendale</h2>
            <p class="text-gray-400">Gestisci le informazioni e le impostazioni della tua attività</p>
        </div>
    </div>

    <!-- Visualizzazione Info Azienda -->
    @if(isset($stats['business_profile']))
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">

            @foreach ($stats['business_profile'] as $business)
                <div class="flex items-center hover:bg-gray-700 px-4">
                    <a href="{{ route('partner.business.show', $business->id) }}"
                        class="flex items-center space-x-6 my-4 w-full">
                        <div class="flex items-center justify-between space-x-6">
                            {{-- LOGO --}}
                            <div class="flex items-center space-x-4">
                                @if($business->logo)
                                    <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0">
                                        <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}"
                                            class="w-full h-full object-contain border border-gray-700 shadow-md">
                                    </div>
                                @else
                                    <div class="w-24 h-24 bg-gray-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- INFO AZIENDA --}}
                                <div class="flex flex-col justify-center">
                                    <h3 class="text-2xl font-semibold text-white leading-tight">
                                        {{ $business->name }}
                                    </h3>

                                    <span
                                        class="mt-2 inline-block px-3 py-1 border border-blue-500/40 text-blue-400 text-xl rounded-full font-medium tracking-wide uppercase w-fit">
                                        {{ $business->businessCategory->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>

                    {{-- BOTTONE MODIFICA --}}

                    <a href="{{ route('partner.business.edit', $business->id) }}">
                        <button
                            class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-md transition-all duration-200">
                            Modifica
                        </button>
                    </a>


                </div>


            @endforeach

        </div>
    @endif


</div>