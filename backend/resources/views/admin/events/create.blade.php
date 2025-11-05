<x-admin-layout title="Crea Nuovo Evento" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Eventi' => route('admin.events.index'),
]">
    <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-5xl md:px-8">
            <x-form-admin :action="route('admin.events.store')" method="POST" title="Crea un nuovo evento" submit-label="Crea Evento"
                enctype="multipart/form-data">
                <x-form-section>
                    <x-input-admin id="title" label="Nome*" type="text" name="title" />
                    <x-input-admin id="description" label="Descrizione Evento" type="text" name="description" />
                    <x-select-admin id="category_id" label="Categoria Evento" name="category_id" :options="$categories"
                        placeholder="Seleziona la categoria"/>
                    <x-input-admin id="image" label="Immagine" type="file" name="image" />
                    <x-input-admin id="starts_at" label="Data Inizio Evento" type="datetime-local" name="starts_at" />
                    <x-input-admin id="ends_at" label="Data Fine Evento" type="datetime-local" name="ends_at" />
                    <x-input-admin id="max_participants" label="Numero Massimo Partecipanti" type="number"
                        name="max_participants" />
                    </x-form-section>
                        
                    {{-- Checkbox volontariato --}}
                    <div x-data="{ isVolunteer: false }" class="pt-6 mt-2 border-t border-border">
                        
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
                                name="volunteer_points" min="1" />
                            </x-form-section>
                        </div>
                    </div>

                <div class="flex flex-row justify-center gap-6">
                    <x-crud-button type="confirm" />
                    <x-crud-button type="delete" label="Annulla" href="{{ route('admin.events.index') }}" />
                </div>
            </x-form-admin>
        </div>
    </div>
</x-admin-layout>
