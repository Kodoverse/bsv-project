<div class="space-y-6">
    <!-- Intestazione -->
    <div>
        <h2 class="text-2xl font-bold text-white">Verifica Codice di Riscatto</h2>
        <p class="text-gray-400">Verifica i codici dei clienti e completa gli ordini in modo sicuro</p>
    </div>

    <!-- Sezione Verifica Codice -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-4">Verifica Codice</h3>

        <form method="POST" action="" class="flex gap-4 mb-6">
            @csrf
            <div class="flex-1">
                <input 
                    name="codice"
                    type="text"
                    value="{{ old('codice') }}"
                    placeholder="Inserisci il codice di riscatto"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent uppercase font-mono"
                >
            </div>
            <button 
                type="submit"
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300"
            >
                Verifica
            </button>
        </form>

        <!-- Risultato Verifica -->
        @isset($risultatoVerifica)
            @if($risultatoVerifica['acquisto'])
                <div class="bg-gray-700/50 rounded-xl p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-white">Dettagli Riscatto</h4>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $risultatoVerifica['classe_stato'] }}">
                            {{ $risultatoVerifica['testo_stato'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Info Cliente -->
                        <div>
                            <h5 class="text-purple-400 font-medium mb-2">Cliente</h5>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ $risultatoVerifica['acquisto']['cliente_iniziali'] }}
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $risultatoVerifica['acquisto']['cliente_nome'] }}</p>
                                    <p class="text-gray-400 text-sm">{{ $risultatoVerifica['acquisto']['cliente_email'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Prodotto -->
                        <div>
                            <h5 class="text-purple-400 font-medium mb-2">Prodotto</h5>
                            <p class="text-white font-medium">{{ $risultatoVerifica['acquisto']['prodotto']['nome'] }}</p>
                            <p class="text-gray-400 text-sm mb-2">{{ $risultatoVerifica['acquisto']['prodotto']['descrizione'] }}</p>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="text-purple-400">{{ $risultatoVerifica['acquisto']['punti_spesi'] }} punti</span>
                                <span class="text-gray-400">Quantità: {{ $risultatoVerifica['acquisto']['quantità'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Acquisto -->
                    <div class="mt-4 pt-4 border-t border-gray-600">
                        <p class="text-gray-400 text-sm">
                            <span class="font-medium">Acquistato il:</span> {{ $risultatoVerifica['acquisto']['creato_il'] }}
                        </p>
                    </div>

                    <!-- Pulsanti Azione -->
                    <div class="flex gap-3 mt-6">
                        @if($risultatoVerifica['può_confermare'] || $risultatoVerifica['può_completare'])
                            <form method="POST" action="{{ route('redenzione.completa', $risultatoVerifica['acquisto']['id']) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-semibold">
                                    Conferma e Completa Ordine
                                </button>
                            </form>
                        @endif

                        @if($risultatoVerifica['acquisto']['stato'] === 'completato')
                            <button disabled class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg opacity-50 cursor-not-allowed">
                                ✅ Ordine Completato
                            </button>
                        @endif

                        @if($risultatoVerifica['acquisto']['stato'] !== 'completato' && $risultatoVerifica['acquisto']['stato'] !== 'annullato')
                            <form method="POST" action="{{ route('redenzione.annulla', $risultatoVerifica['acquisto']['id']) }}">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Annulla
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <!-- Stato Errore -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-xl p-6 mt-6">
                    <div class="flex items-center gap-3 text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-medium">Codice di riscatto non valido</p>
                    </div>
                    <p class="text-red-300 text-sm mt-2">Il codice inserito non è stato trovato o non appartiene alla tua attività.</p>
                </div>
            @endif
        @endisset
    </div>

    <!-- Azioni Rapide -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Inserimento Manuale -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <h3 class="text-white font-semibold mb-2">Inserisci Codice</h3>
            <p class="text-gray-400 text-sm mb-4">Digita il codice nel campo in alto</p>
            <button onclick="document.querySelector('input[name=codice]').focus()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Vai al Campo
            </button>
        </div>

        <!-- Storico Vendite -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-white font-semibold mb-2">Analisi Vendite</h3>
            <p class="text-gray-400 text-sm mb-4">Consulta transazioni e guadagni completati</p>
            <a href="" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Visualizza Storico
            </a>
        </div>
    </div>

    <!-- Istruzioni per Partner -->
    <div class="bg-gradient-to-br from-blue-900/20 to-purple-900/20 border border-blue-500/30 rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-4">Come Gestire un Riscatto</h3>

        <div class="space-y-3 text-gray-300">
            <div class="flex items-start gap-3">
                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">1</span>
                <p>Il cliente ti fornisce il <strong>codice di riscatto</strong></p>
            </div>
            <div class="flex items-start gap-3">
                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">2</span>
                <p>Inserisci il codice sopra e clicca <strong>"Verifica"</strong></p>
            </div>
            <div class="flex items-start gap-3">
                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">3</span>
                <p>Controlla i dettagli dell’ordine e clicca <strong>"Conferma e Completa Ordine"</strong></p>
            </div>
            <div class="flex items-start gap-3">
                <span class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">4</span>
                <p>Consegnare il prodotto o servizio al cliente</p>
            </div>
        </div>

        <div class="mt-4 p-4 bg-yellow-900/20 border border-yellow-500/30 rounded-lg">
            <p class="text-yellow-200 text-sm">
                <strong>🔒 Nota di Sicurezza:</strong> Solo i codici di riscatto validi appartenenti ai tuoi clienti verranno accettati.
                Ogni codice può essere usato una sola volta e scade dopo il completamento.
            </p>
        </div>
    </div>
</div>