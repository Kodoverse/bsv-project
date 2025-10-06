@extends('layouts.mystyle')
@section('content')

    <x-app-layout>


        <div class="flex flex-col items-center w-full overflow-hidden">

            <div class="w-full py-12">
                <div class="w-full">
                    <div>
                        <div class="flex justify-between">
                            <div v-if="user" class="flex flex-col gap-5 py-6 ps-6">
                                <h1 class="text-3xl tracking-wide uppercase dark:text-white">Create an Event</h1>
                            </div>
                        </div>

                        <div class="w-full px-6">

                            <div class="flex justify-start">

                                <form action="{{ route('events.store') }}" enctype="multipart/form-data" method="POST"
                                    class="w-full max-w-xl">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="title"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                        <input type="text" id="title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') is-invalid 
                                  @enderror"
                                            name="title">
                                        @error('title')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <input type="text" id="description"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('description') is-invalid 
                                  @enderror"
                                            name="description">
                                        @error('description')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="category_id"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Categoria
                                        </label>
                                        <select id="category_id" name="category_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                                                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                                                  dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('category_id') is-invalid @enderror">
                                            <option value="">Seleziona una categoria</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image -->
                                    <div class="mb-5">
                                        <label for="image"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Immagine evento
                                        </label>
                                        <input type="file" id="image" name="image"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
               block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
               dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('image') is-invalid @enderror"
                                            accept="image/*">
                                        @error('image')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Starts At -->
                                    <div class="mb-5">
                                        <label for="starts_at"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Data inizio
                                        </label>
                                        <input type="datetime-local" id="starts_at" name="starts_at"
                                            value="{{ old('starts_at') }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
               block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
               dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('starts_at') is-invalid @enderror">
                                        @error('starts_at')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-5">
                                        <label for="ends_at"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Data fine
                                        </label>
                                        <input type="datetime-local" id="ends_at" name="ends_at"
                                            value="{{ old('ends_at') }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
               block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
               dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('ends_at') is-invalid @enderror">
                                        @error('ends_at')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Max Participants -->
                                    <div class="mb-5">
                                        <label for="max_participants"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Numero massimo di partecipanti
                                        </label>
                                        <input type="number" id="max_participants" name="max_participants"
                                            value="{{ old('max_participants') }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('max_participants') is-invalid @enderror"
                                            min="1">
                                        @error('max_participants')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div x-data="{ isVolunteer: false }" class="mb-5">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_volunteer_event" x-model="isVolunteer"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600">
                                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Evento di
                                                volontariato</span>
                                        </label>

                                        <div x-show="isVolunteer" x-transition class="mt-4">
                                            <label for="volunteer_points"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                Punti volontariato
                                            </label>
                                            <input type="number" id="volunteer_points" name="volunteer_points"
                                                min="1"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                      focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                      dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                      @error('volunteer_points') is-invalid @enderror">
                                            @error('volunteer_points')
                                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <button type="submit"
                                        class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Create</button>
                                    <a href="{{ route('events.index') }}"></a>

                                </form>

                            </div>
                        </div>


    </x-app-layout>

@endsection
