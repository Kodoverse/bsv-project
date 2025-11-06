    <x-admin-layout title="Modifca Evento {{ $event->title }}" :breadcrumbs="[
        'Dashboard' => route('admin.dashboard'),
        'Eventi' => route('admin.events.index'),
        '{{ $event->title }}' => route('admin.events.show', $event->id),
    ]">
        <div class="flex flex-col items-center w-full py-10 overflow-hidden">
            <div class="w-full max-w-5xl md:px-8">
                <x-form-admin :action="route('admin.events.update', $event->id)" method="PUT" title="Modifica evento" submit-label="Modifica Evento"
                    enctype="multipart/form-data">
                    <x-form-section>
                        <x-input-admin id="title" label="Nome" type="text" name="title"
                            value="{{ old('title') ?? $event->title }}" />
                        <x-input-admin id="description" label="Descrizione Evento" type="text" name="description"
                            value="{{ old('description') ?? $event->description }}" />
                        <x-select-admin id="category_id" name="category_id" :options="$categories"
                            label="Seleziona Categoria Evento" placeholder="Seleziona la categoria"
                            :value="old('category_id', $event->category_id)"></x-select-admin>
                        <x-input-admin class="" id="image" label="Immagine" type="file" name="image" />
                        @if ($event->image_url)
                            <div class="mt-2">
                                <p class="text-sm text-gray-700">Immagine attuale:</p>
                                <img src="{{ asset($event->image_url) }}" alt="Immagine evento"
                                    class="object-cover w-32 h-32 rounded">
                            </div>
                        @endif
                        <x-input-admin id="starts_at" label="Data Inizio Evento" type="datetime-local" name="starts_at"
                            value="{{ old('starts_at') ?? $event->starts_at }}" />
                        <x-input-admin id="ends_at" label="Data Fine Evento" type="datetime-local" name="ends_at"
                            value="{{ old('ends_at') ?? $event->ends_at }}" />
                        <x-input-admin id="max_participants" label="Numero Massimo Partecipanti" type="number"
                            name="max_participants" value="{{ old('max_participants') ?? $event->max_participants }}" />
                    </x-form-section>
                    <div x-data="{ isVolunteer: @json((bool) old('is_volunteer_event', $event->is_volunteer_event ?? false)) }" class="pt-6 mt-2 border-t border-border">

                        <label class="inline-flex items-center justify-center gap-2 cursor-pointer">
                            <x-checkbox-admin name="is_volunteer_event" x-model="isVolunteer" />
                            <span class="text-sm font-medium text-foreground">
                                Evento di volontariato
                            </span>
                        </label>

                        <div x-show="isVolunteer" x-transition:enter="transition-all ease-out duration-300"
                            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-40"
                            x-transition:leave="transition-all ease-in duration-300"
                            x-transition:leave-start="opacity-100 max-h-40" x-transition:leave-end="opacity-0 max-h-0"
                            class="mt-4 overflow-hidden">
                            <x-form-section>
                                <x-input-admin id="volunteer_points" label="Punti Ottenibili" type="number"
                                    name="volunteer_points" min="1"
                                    value="{{ old('volunteer_points', $event->volunteer_points ?? '') }}" />
                            </x-form-section>
                        </div>
                    </div>
            </div>
            <div class="flex flex-row justify-center gap-6">
                <x-crud-button type="confirm" label="Modifica" />
                <x-crud-button type="delete" label="Annulla" href="{{ route('admin.events.show', $event->id) }}" />
            </div>
            </x-form-admin>
        </div>
        </div>
    </x-admin-layout>
