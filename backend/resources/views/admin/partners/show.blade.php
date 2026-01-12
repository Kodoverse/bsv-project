
<x-admin-layout title="{{ $partner->partnerInfo->name . ' ' . $partner->partnerInfo->lastname }}">
    <div class="w-full">Totale Attivita' Partner: {{ $partner->businesses->count() }}</div>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    <!-- ACCOUNT INFO -->
    <div class="p-6 bg-white border shadow-sm rounded-xl">
        <h2 class="mb-4 text-lg font-semibold">Account</h2>
        <ul class="space-y-2 text-sm">
            <li><strong>ID:</strong> {{ $partner->id }}</li>
            <li><strong>Email:</strong> {{ $partner->email }}</li>
            <li><strong>Ruolo:</strong> {{ $partner->user_role }}</li>
            <li><strong>Creato il:</strong> {{ $partner->created_at->format('d/m/Y H:i') }}</li>
        </ul>
    </div>

    <!-- PARTNER INFO -->
    <div class="p-6 bg-white border shadow-sm rounded-xl">
        <h2 class="mb-4 text-lg font-semibold">Profilo Partner</h2>

        @if ($partner->partnerInfo)
            <ul class="space-y-2 text-sm">
                <li><strong>Nome:</strong> {{ $partner->partnerInfo->name }}</li>
                <li><strong>Cognome:</strong> {{ $partner->partnerInfo->lastname }}</li>
                <li><strong>Data di nascita:</strong> {{ $partner->partnerInfo->birthday }}</li>
                <li><strong>Telefono:</strong> {{ $partner->partnerInfo->contact_phone }}</li>
                <li><strong>Punti minimi:</strong> {{ $partner->partnerInfo->min_points_per_redemption }}</li>
                <li><strong>Punti massimi:</strong> {{ $partner->partnerInfo->max_points_per_redemption }}</li>
                <li>
                    <strong>Attivo:</strong>
                    <span class="{{ $partner->partnerInfo->is_active ? 'text-green-600' : 'text-red-600' }}">
                        {{ $partner->partnerInfo->is_active ? 'Sì' : 'No' }}
                    </span>
                </li>
            </ul>
        @else
            <p class="text-muted">Nessuna informazione partner disponibile.</p>
        @endif
    </div>

    <!-- BUSINESS ASSOCIATI -->
    <div class="p-6 bg-white border shadow-sm md:col-span-2 rounded-xl">
        <h2 class="mb-4 text-lg font-semibold">Business associati</h2>

        @if ($partner->businesses && $partner->businesses->count())
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($partner->businesses as $business)
                    <div class="p-4 border rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-md">{{ $business->name }}</h3>
                        <ul class="mt-2 space-y-1 text-sm">
                            <li><strong>ID:</strong> {{ $business->id }}</li>
                            <li><strong>Indirizzo:</strong> {{ $business->address }}</li>
                            <li><strong>Email:</strong> {{ $business->email }}</li>
                            <li><strong>Sito:</strong> {{ $business->website }}</li>
                        </ul>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Nessun business associato.</p>
        @endif
    </div>

</div>

    </x-admin-layout>
