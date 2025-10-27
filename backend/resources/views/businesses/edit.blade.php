<!-- Form Profilo Aziendale -->
<div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 mt-6">
    <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nome Azienda -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nome Azienda *</label>
                <input name="business_name" type="text"
                    value="{{ old('business_name', $business->business_name ?? '') }}" required
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Inserisci il nome dell'azienda">
            </div>

            <!-- Categoria -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Categoria *</label>
                <select name="business_category" required
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Seleziona categoria</option>
                    @foreach($stats['categoriesBusiness'] as $value => $label)
                        <option value="{{ $value }}" {{ (old('business_category', $business->business_category ?? '') == $value) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Indirizzo -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-300 mb-2">Indirizzo</label>
                <input name="business_address" type="text"
                    value="{{ old('business_address', $business->business_address ?? '') }}"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Inserisci l'indirizzo dell'azienda">
            </div>

            <!-- Descrizione -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-300 mb-2">Descrizione</label>
                <textarea name="business_description" rows="3"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Descrivi la tua azienda">{{ old('business_description', $business->business_description ?? '') }}</textarea>
            </div>

            <!-- Contatti -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Telefono</label>
                <input name="contact_phone" type="tel"
                    value="{{ old('contact_phone', $business->contact_phone ?? '') }}"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Numero di telefono">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input name="business_email" type="email"
                    value="{{ old('business_email', $business->business_email ?? '') }}"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Email aziendale">
            </div>

            <!-- Sito Web -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Sito Web</label>
                <input name="business_website" type="url"
                    value="{{ old('business_website', $business->business_website ?? '') }}"
                    class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://tuo-sito.com">
            </div>

            <!-- Logo Azienda -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Logo Azienda</label>
                <input type="file" name="business_logo" accept="image/*" class="w-full text-gray-300">
                @if(isset($business->business_logo))
                    <div class="mt-2">
                        <img src="{{ $business->business_logo }}" alt="Logo" class="w-20 h-20 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </div>

        <!-- Pulsanti Azione -->
        <div class="flex space-x-4 pt-4">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                {{ isset($business) ? 'Aggiorna Profilo' : 'Crea Profilo' }}
            </button>
            <a href="{{ route('dashboard') }}"
                class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Annulla
            </a>
        </div>
    </form>
</div>