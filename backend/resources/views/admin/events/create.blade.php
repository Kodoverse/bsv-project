    <x-admin-layout title="Crea Nuovo Evento">
        <div class="flex flex-col w-full overflow-hidden">


            <div class="px-12 ">
                <x-form-admin :action="route('admin.events.store')" method="POST" title="Crea un nuovo evento" submit-label="Crea Evento" enctype="multipart/form-data">
                    <x-input-admin class="border-red-500" id="title" label="Nome" type="text" name="title" />
                    <x-input-admin id="description" label="Descrizione Evento" type="text" name="description" />
                    <x-select-admin id="category_id" name="category_id" :options="$categories"
                        placeholder="Seleziona la categoria"></x-select-admin>
                    <x-input-admin id="image" label="Immagine" type="file" name="image" />
                    <x-input-admin id="starts_at" label="Data Inizio Evento" type="datetime-local" name="starts_at" />
                    <x-input-admin id="ends_at" label="Data Fine Evento" type="datetime-local" name="ends_at" />
                    <x-input-admin id="max_participants" label="Numero Massimo Partecipanti" type="number"
                        name="max_participants" />

                    <div x-data="{ isVolunteer: false }" class="mb-5">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_volunteer_event" x-model="isVolunteer"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600">
                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Evento di
                                volontariato</span>
                        </label>
                        <div x-show="isVolunteer" x-transition class="mt-4">
                              <x-input-admin id="volunteer_points" label="Punti Ottenibili" type="volunteer_points"  min="1"/>
                        </div>

                    </div>
                    <div class="flex justify-center">
                        <x-crud-button type="confirm" :href="route('admin.events.index')"></x-crud-button>
                    </div>
                </x-form-admin>
            </div>
        </div>

    </x-admin-layout>














