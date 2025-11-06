<x-admin-layout title="Modifica Partner {{ $partner->partnerInfo->name . ' ' . $partner->partnerInfo->lastname }}"
    :breadcrumbs="[
        'Dashboard' => route('admin.dashboard'),
        'Partner' => route('admin.partners.index'),
        '{{ $event->title }}' => route('admin.partners.show', $partner->id),
    ]">

    <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-5xl md:px-8">
            <x-form-admin :action="route('admin.partners.update', $partner->id)" method="PUT" title="Modifica Partner" submit-label="Modifica Partner"
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
        <div class="flex flex-row justify-center gap-6">
            <x-crud-button type="confirm" />
            <x-crud-button type="delete" label="Annulla" href="{{ route('admin.partners.index') }}" />
        </div>
        <div class="text-sm italic text-gray-400">{{ '(*) Dati Obbligatori' }}</div>
        </x-form-admin>
    </div>
    </div>
</x-admin-layout>
