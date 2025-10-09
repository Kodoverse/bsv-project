<div class="space-y-6">
    <!-- Intestazione -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Profilo Aziendale</h2>
            <p class="text-gray-400">Gestisci le informazioni e le impostazioni della tua attività</p>
        </div>
        <a href=""
           class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
            {{ isset($partner) ? 'Modifica Profilo' : 'Crea Profilo' }}
        </a>
    </div>

    <!-- Visualizzazione Info Azienda -->
    @if(isset($partner))
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
            <div class="flex items-start space-x-6">
                <!-- Logo Azienda -->
                <div class="flex-shrink-0">
                    @if($partner->business_logo)
                        <div class="w-24 h-24 rounded-xl overflow-hidden">
                            <img src="{{ $partner->business_logo }}" alt="{{ $partner->business_name }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 bg-gray-700 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Dettagli Azienda -->
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h3 class="text-xl font-semibold text-white">{{ $partner->business_name }}</h3>
                        <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-full text-sm font-medium capitalize">
                            {{ $partner->business_category }}
                        </span>
                        @if($partner->is_active)
                            <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-full text-sm font-medium">
                                Attiva
                            </span>
                        @endif
                    </div>

                    @if($partner->business_description)
                        <p class="text-gray-300 mb-3">{{ $partner->business_description }}</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        @if($partner->business_address)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-300">{{ $partner->business_address }}</span>
                            </div>
                        @endif

                        @if($partner->contact_phone)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <span class="text-gray-300">{{ $partner->contact_phone }}</span>
                            </div>
                        @endif

                        @if($partner->business_email)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <span class="text-gray-300">{{ $partner->business_email }}</span>
                            </div>
                        @endif

                        @if($partner->business_website)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ $partner->business_website }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                    {{ $partner->business_website }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Profilo Aziendale -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 mt-6">
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome Azienda -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nome Azienda *</label>
                    <input name="business_name" type="text" value="{{ old('business_name', $partner->business_name ?? '') }}" required
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Inserisci il nome dell'azienda">
                </div>

                <!-- Categoria -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Categoria *</label>
                    <select name="business_category" required
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Seleziona categoria</option>
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}" {{ (old('business_category', $partner->business_category ?? '') == $value) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Indirizzo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Indirizzo</label>
                    <input name="business_address" type="text" value="{{ old('business_address', $partner->business_address ?? '') }}"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Inserisci l'indirizzo dell'azienda">
                </div>

                <!-- Descrizione -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Descrizione</label>
                    <textarea name="business_description" rows="3"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Descrivi la tua azienda">{{ old('business_description', $partner->business_description ?? '') }}</textarea>
                </div>

                <!-- Contatti -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Telefono</label>
                    <input name="contact_phone" type="tel" value="{{ old('contact_phone', $partner->contact_phone ?? '') }}"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Numero di telefono">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input name="business_email" type="email" value="{{ old('business_email', $partner->business_email ?? '') }}"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Email aziendale">
                </div>

                <!-- Sito Web -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Sito Web</label>
                    <input name="business_website" type="url" value="{{ old('business_website', $partner->business_website ?? '') }}"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://tuo-sito.com">
                </div>

                <!-- Logo Azienda -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Logo Azienda</label>
                    <input type="file" name="business_logo" accept="image/*" class="w-full text-gray-300">
                    @if(isset($partner->business_logo))
                        <div class="mt-2">
                            <img src="{{ $partner->business_logo }}" alt="Logo" class="w-20 h-20 object-cover rounded-lg">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pulsanti Azione -->
            <div class="flex space-x-4 pt-4">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                    {{ isset($partner) ? 'Aggiorna Profilo' : 'Crea Profilo' }}
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Annulla
                </a>
            </div>
        </form>
    </div>
</div>