@extends('layouts.partner')

@section('content')
    <div class="max-w-6xl mx-auto p-8 bg-gray-800 text-white rounded-2xl shadow-lg space-y-8">
        <div class="mb-6">
            <a href="{{ route('partner.dashboard', ['tab' => 'profile']) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                ← Torna indietro
            </a>
        </div>

        {{-- Header: Nome azienda + stato --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">{{ $business->name }}</h1>

        </div>

        {{-- Sezione principale: logo + info azienda --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
            {{-- Logo --}}
            <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}"
                    class="rounded-xl shadow-md w-full object-cover max-w-xs">
            </div>

            {{-- Info azienda --}}
            <div class="w-full md:w-2/3 space-y-4">
                <p class="text-gray-300"><span class="font-semibold">Sito Web:</span> <a href="{{ $business->website }}"
                        class="text-indigo-400 hover:underline" target="_blank">{{ $business->website }}</a></p>
                <p class="text-gray-300"><span class="font-semibold">Email:</span> {{ $business->email }}</p>
                <p class="text-gray-300"><span class="font-semibold">Indirizzo:</span> {{ $business->address }}</p>
                <p class="text-gray-300"><span class="font-semibold">Categoria:</span>
                    {{ $business->businessCategory->name ?? 'N/A' }}</p>
                <p class="text-gray-300"><span class="font-semibold">Descrizione:</span> {{ $business->description }}</p>
            </div>
        </div>

        {{-- Divider --}}
        <hr class="border-gray-700">

        {{-- Dati partner --}}
        <div class="space-y-4">
            <h2 class="text-2xl font-bold">Dati del Partner</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex  items-center">
                    <h3 class="text-xl font-semibold">{{ $partner->name }} {{ $partner->lastname }}</h3>
                    <span
                        class="px-2 py-1 rounded-full text-lg font-semibold mx-4 {{ $partner->is_active ? 'bg-green-600' : 'bg-red-600' }}">
                        {{ $partner->is_active ? 'Attivo' : 'Inattivo' }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-300"><span class="font-semibold">Telefono:</span> {{ $partner->contact_phone }}</p>
                    <p class="text-gray-300"><span class="font-semibold">Regole di riscatto:</span>
                        {{ $partner->redemption_rules ?? 'N/A' }}</p>
                    <p class="text-gray-300"><span class="font-semibold">Punti minimi per riscatto:</span>
                        {{ $partner->min_points_per_redemption }}</p>
                    <p class="text-gray-300"><span class="font-semibold">Punti massimi per riscatto:</span>
                        {{ $partner->max_points_per_redemption ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Eventuale sezione prodotti --}}
        @if($business->products->count())
            <hr class="border-gray-700">
            <div class="space-y-4">
                <h2 class="text-2xl font-bold">Prodotti</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($business->products as $product)
                        <div class="bg-gray-700 rounded-xl p-4 flex flex-col items-center space-y-4">
                            <img src="{{ $product->image_url ? Storage::url($product->image_url) : asset('images/placeholder.png') }}"
                                alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg">
                            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                            <p class="text-gray-300">{{ $product->description }}</p>
                            <p class="text-gray-300 font-semibold">{{ $product->points_price }} punti</p>
                            <p class="{{ $product->is_available ? 'text-green-400' : 'text-red-400' }}">
                                {{ $product->is_available ? 'Disponibile' : 'Non disponibile' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection