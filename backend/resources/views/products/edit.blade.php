@extends("layouts.partner")
@section('content')
    <div class="flex flex-col items-center w-full min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">

            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white uppercase tracking-wide">
                    Modifica prodotto
                </h1>
                <a href="{{ route('partner.dashboard', ['tab' => 'products']) }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-400">
                    ← Torna all'elenco
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('partner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @csrf
                @method('PATCH')

                {{-- Nome --}}
                <div class="col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descrizione --}}
                <div class="col-span-2">
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrizione</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">{{ old('description', $product->description)  }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prezzo in punti --}}
                <div>
                    <label for="points_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prezzo
                        (punti)</label>
                    <input type="number" id="points_price" name="points_price"
                        value="{{ old('points_price', $product->points_price) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                    @error('points_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Equivalente in denaro --}}
                <div>
                    <label for="cash_equivalent"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Equivalente in denaro (€)</label>
                    <input type="number" id="cash_equivalent" name="cash_equivalent"
                        value="{{ old('cash_equivalent', $product->cash_equivalent) }}" step="0.01"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                    @error('cash_equivalent')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantità disponibile --}}
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantità
                        disponibile</label>
                    <input type="number" id="stock_quantity" name="stock_quantity"
                        value="{{ old('stock_quantity', $product->stock_quantity) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                    @error('stock_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categoria --}}
                <div>
                    <label for="category"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                    <select type="text" id="category" name="category_id"
                        value="{{ old('category', $product->category_id) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Disponibilità --}}
                <div>
                    <label for="is_available"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disponibile</label>
                    <div class="flex mt-4">
                        <div class="flex items-center me-4">
                            <input id="default-radio-1" type="radio" value="1" {{ old('is_available', $product->is_available) == 1 ? 'checked' : '' }} name="is_available"
                                class="w-4 h-4 text-orange-600 bg-orange-300 border-orange-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Si</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="0" {{ old('is_available', $product->is_available) == 0 ? 'checked' : '' }} name="is_available"
                                class="w-4 h-4 text-orange-600 bg-orange-300 border-orange-300  dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                        </div>
                    </div>
                    @error('is_available')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Metadati --}}
                <div class="col-span-2 lg:col-span-3">
                    <label for="metadata" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metadati (JSON
                        opzionale)</label>
                    <textarea id="metadata" name="metadata" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">{{ old('metadata') }}</textarea>
                    @error('metadata')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Immagine --}}
                <div class="col-span-2 lg:col-span-3">
                    <div id="previews" class="w-75  text-center">
                        <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                            src="{{ $product->image_url ? Storage::url($product->image_url) : asset('images/placeholder.png') }}"
                            alt="preview">
                    </div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Immagine del
                        prodotto</label>
                    <input type="file" id="uploadImage" accept="image/*" name="image_url"
                        class="mt-1 block w-full text-gray-900 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer focus:outline-none p-2.5">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pulsante --}}
                <div class="col-span-2 lg:col-span-3 flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-400 transition">
                        Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection