<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Gestione Vendite</h2>
            <p class="text-gray-400">Visualizza e gestisci le tue transazioni di vendita</p>
        </div>

        <div class="flex gap-4">
            <form method="GET" action="{{ route('partner.dashboard') }}">
                {{-- Mantieni il tab corrente --}}
                <input type="hidden" name="tab" value="sales">

                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Tutti</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>In sospeso</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confermata</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completata</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancellata</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-800 to-blue-900 border border-blue-700 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Totale Vendite</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_sales'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-800 to-yellow-900 border border-yellow-700 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-300 text-sm font-medium">Ordini in sospeso</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['pending_orders'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-800 to-green-900 border border-green-700 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">Completate</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['status_count']['completed'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-800 to-purple-900 border border-purple-700 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">Punti Guadagnati</p>
                    <p class="text-2xl font-bold text-white">
                        {{ $stats['total_points_completed'] ? $stats['total_points_completed'] : 0 }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales List -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden mt-6">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white">Recent Sales</h3>
        </div>

        @if ($stats['recent_sales']->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-400 text-lg">No sales yet</p>
                <p class="text-gray-500 text-sm mt-2">Sales will appear here when customers purchase your products.</p>
            </div>
        @else
            <div class="divide-y divide-gray-700">
                @foreach ($stats['recent_sales'] as $sale)
                    <div class="p-6 hover:bg-gray-700/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($sale->user->email ?? 'U', 0, 1)) }}
                                </div>

                                <div>
                                    <h4 class="text-white font-medium">
                                        {{ $sale->product->name ?? 'Prodotto eliminato' }}
                                    </h4>
                                    <p class="text-gray-400 text-lg">{{ $sale->user->display_name ?? 'Utente sconosciuto' }}</p>
                                    <p class="text-gray-500 text-xs">{{ $sale->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-purple-400 font-semibold">{{ $sale->points_spent }} pts</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-md font-semibold border {{ $sale->status_badge_class }}">
                                        {{ $sale->formatted_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-gray-800/50 rounded-lg flex justify-between items-center">
                            <p class="text-gray-400 text-sm">
                                <span class="font-medium">Transaction ID:</span>
                                <span class="ml-2 font-mono text-purple-400">#{{ $sale->id }}</span>
                            </p>

                            <div class="flex gap-2 mt-2">
                                {{-- Bottone Conferma --}}
                                @if($sale->status === 'pending')
                                    <form method="POST" action="{{ route('partner.sales.updateStatus', $sale->id) }}">  
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit"
                                            class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            Confirm
                                        </button>
                                    </form>
                                @endif

                                {{-- Bottone Completa --}}
                                @if($sale->status === 'confirmed')
                                    <form method="POST" action="{{ route('partner.sales.updateStatus', $sale->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                            Complete
                                        </button>
                                    </form>
                                @endif

                                {{-- Bottone Annulla --}}
                                @if(in_array($sale->status, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('partner.sales.updateStatus', $sale->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    {{ $stats['recent_sales']->links() }}
</div>