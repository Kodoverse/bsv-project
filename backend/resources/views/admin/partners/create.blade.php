<x-admin-layout title="Aggiungi Nuovo Partner" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Partner' => route('admin.partners.index'),
    ]">
    <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-5xl px-8">
            
            <x-form-admin :action="route('admin.partners.store')" method="POST" title="Crea un nuovo evento" submit-label="Crea Evento"
                enctype="multipart/form-data">
                <x-form-section>
                    <x-input-admin id="name" label="Nome*" type="text" name="name" />
                    <x-input-admin id="lastname" label="Cognome*" type="text" name="lastname" />
                    <x-input-admin id="email" label="Indirizzo Email*" type="email" name="email" />
                    <x-input-admin id="birthday" label="Data di Nascita" type="date" name="birthday" />
                    <x-input-admin id="contact_phone" label="Recapito Telefonico" type="text" name="contact_phone" />
                    <div class="visible"></div>
                    <label for="is_active" class="inline-flex items-center gap-2 cursor-pointer">
                        <x-checkbox-admin id="is_active" name="is_active" label="Attiva Partner" />
                        <span class="text-sm font-medium text-foreground">
                            Attiva Partner
                        </span>
                    </label>
                </x-form-section>

                
                <div x-data="{ isAddingBusiness: {{ old('addBusiness') ? 'true' : 'false' }} }" class="pt-6 mt-2 border-t border-border">
                     <label class="inline-flex items-center justify-center gap-2 cursor-pointer">
                        <x-checkbox-admin name="addBusiness" x-model="isAddingBusiness" />
                        <span class="text-sm font-medium text-foreground">
                            Inserisci Attività Partner
                        </span>
                    </label>
                        <fieldset 
                        
        :disabled="!isAddingBusiness" 
        x-transition:enter="transition-all ease-out duration-500"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-[600px]"
        x-transition:leave="transition-all ease-in duration-500"
        x-transition:leave-start="opacity-100 max-h-[600px]"
        x-transition:leave-end="opacity-0 max-h-0"
        class="pt-4 mt-4 overflow-hidden border-t border-border"
    >
                    <div x-show="isAddingBusiness" x-transition:enter="transition-all ease-out duration-500"
                        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-[600px]"
                        x-transition:leave="transition-all ease-in duration-500"
                        x-transition:leave-start="opacity-100 max-h-[600px]" x-transition:leave-end="opacity-0 max-h-0"
                        class="mt-4 overflow-hidden">
                        <x-form-section title="Attività Partner">
                            <x-input-admin id="business_name" type="text" name="business_name"
                                label="Nome Attività*" />
                            <x-select-admin label="Categoria" id="business_category_id" name="business_category_id"
                                :options="$busCategory" placeholder="Seleziona Categoria" />
                            <x-input-admin id="business_address" type="text" name="business_address"
                                label="Indirizzo Attività*" />
                            <x-input-admin id="business_description" type="text" name="business_description"
                                label="Descrizione Attività" />
                            <x-input-admin id="business_email" type="email" name="business_email"
                                label="Indirizzo Email Attività" />
                            <x-input-admin id="website" type="text" name="website"
                                label="Sito Web" />
                            <x-input-admin id="logo" type="file" name="logo"
                                label="Logo" />
                        </x-form-section>
                        </fieldset>
                    </div>
                </div>
                <div class="flex flex-row justify-center gap-6">
                    <x-crud-button type="confirm" />
                    <x-crud-button type="delete" label="Annulla" href="{{ route('admin.partners.index') }}"/>
                </div>
                <div class="text-sm italic text-gray-400">{{ "(*) Dati Obbligatori" }}</div>
            </x-form-admin>
        </div>
    </div>
</x-admin-layout>
