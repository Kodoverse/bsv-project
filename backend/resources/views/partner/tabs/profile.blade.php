<div class="space-y-6">
    <!-- Intestazione -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Profilo Aziendale</h2>
            <p class="text-gray-400">Gestisci le informazioni e le impostazioni della tua attività</p>
        </div>
        <a href=""
            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
            {{ isset($stats['business_profile']) ? 'Modifica Profilo' : 'Crea Profilo' }}
        </a>
    </div>

    <!-- Visualizzazione Info Azienda -->
    @if(isset($stats['business_profile']))
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
            <div>
                @foreach ($stats['business_profile'] as $business)
                    <a href="{{ route('partner.business.show', $business->id) }}" class="flex items-center space-x-6 my-4">


                        <!-- Logo Azienda -->
                        <div class="flex-shrink-0">
                            @if($business->logo)
                                <div class="w-24 h-24 rounded-xl overflow-hidden">
                                    <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}"
                                        class="w-full h-full object-contain">
                                </div>
                            @else
                                <div class="w-24 h-24 bg-gray-700 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Dettagli Azienda -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between space-x-3 mb-2">
                                <h3 class="text-xl font-semibold text-white">{{ $business->name }}</h3>
                                <a href="{{ route('partner.business.edit', $business->id) }}">
                                    <button
                                        class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">Modifica</button>
                                </a>
                            </div>
                            <div>
                                <span
                                    class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-full text-xl font-medium capitalize">
                                    {{ $business->businessCategory->name }}
                                </span>
                            </div>

                            @if($business->business_description)
                                <p class="text-gray-300 mb-3">{{ $business->business_description }}</p>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                @if($business->business_address)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-300">{{ $business->business_address }}</span>
                                    </div>
                                @endif

                                @if($business->contact_phone)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span class="text-gray-300">{{ $business->contact_phone }}</span>
                                    </div>
                                @endif

                                @if($business->business_email)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="text-gray-300">{{ $business->business_email }}</span>
                                    </div>
                                @endif

                                @if($business->business_website)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <a href="{{ $business->business_website }}" target="_blank"
                                            class="text-blue-400 hover:text-blue-300">
                                            {{ $business->business_website }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif


</div>