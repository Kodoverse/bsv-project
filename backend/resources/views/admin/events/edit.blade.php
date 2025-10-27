@extends('layouts.admin')
@section('content')
    <x-app-layout>
        <x-page-header title="Modifca Evento {{ $event->title }}" />
        <div class="flex flex-col w-full px-12 overflow-hidden">


            <div>
                <x-form-admin :action="route('events.update', $event->id)" method="PUT" title="Crea un nuovo evento" submit-label="Crea Evento"
                    enctype="multipart/form-data">
                    <x-input-admin id="title" label="Nome" type="text" name="title"
                        value="{{ old('title') ?? $event->title }}" />
                    <x-input-admin id="description" label="Descrizione Evento" type="text" name="description"
                        value="{{ old('description') ?? $event->description }}" />
                    <x-select-admin id="category_id" name="category_id" :options="$categories" label="Seleziona Categoria Evento"
                        placeholder="Seleziona la categoria" :value="old('category_id', $event->category_id)"></x-select-admin>
                    <x-input-admin class="" id="image" label="Immagine" type="file" name="image" />
                    @if ($event->image_url)
                        <div class="mt-2">
                            <p class="text-sm text-gray-700">Immagine attuale:</p>
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="Immagine evento"
                                class="object-cover w-32 h-32 rounded">
                        </div>
                    @endif
                    <x-input-admin id="starts_at" label="Data Inizio Evento" type="datetime-local" name="starts_at"
                        value="{{ old('starts_at') ?? $event->starts_at }}" />
                    <x-input-admin id="ends_at" label="Data Fine Evento" type="datetime-local" name="ends_at"
                        value="{{ old('ends_at') ?? $event->ends_at }}" />
                    <x-input-admin id="max_participants" label="Numero Massimo Partecipanti" type="number"
                        name="max_participants" value="{{ old('max_participants') ?? $event->max_participants }}" />

                    <div x-data="{ isVolunteer: @json((bool) old('is_volunteer_event', $event->is_volunteer_event ?? false)) }" class="mb-5">
                        <label class="inline-flex items-center">
                            <input type="hidden" name="is_volunteer_event" value="0">

                            <input type="checkbox" name="is_volunteer_event" value="1" x-model="isVolunteer"
                                @checked(old('is_volunteer_event', $event->is_volunteer_event ?? false))
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600">
                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                                Evento di volontariato
                            </span>
                        </label>

                        <div x-show="isVolunteer" x-transition class="mt-4">
                            <x-input-admin id="volunteer_points" label="Punti Ottenibili" type="number"
                                name="volunteer_points" min="1"
                                value="{{ old('volunteer_points', $event->volunteer_points ?? '') }}" />
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <x-crud-button type="confirm" :href="route('events.index')"></x-crud-button>
                    </div>
                </x-form-admin>
                <div class="flex justify-center">
                    <a href="{{ route('events.index') }}">
                    <x-crud-button type="delete" label="Annulla"></x-crud-button>
                    </a>
                </div>
            </div>
        </div>

    </x-app-layout>
@endsection
