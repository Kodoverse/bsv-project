<x-admin-layout title="I Partner" subtitle="Gestione partner" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Partner' => null,
]">
    <x-table-toolbar>
        <x-slot:filters>
            <x-table-filters searchPlaceholder="Cerca Partner...">
                <x-select-admin
                id="status"
                name="status"
                :options="[
                    (object)['id' => 'draft', 'name' => 'In Bozza'],
                    (object)['id' => 'upcoming', 'name' => 'In Programma'],
                    (object)['id' => 'finished', 'name' => 'Terminato'],
                    (object)['id' => 'cancelled', 'name' => 'Cancellato']
                ]"
                :value="request('status')"
                placeholder="Tutti gli stati"
            />

            {{-- Checkbox volontariato --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_volunteerevent" value="1" id="is_volunteer_event"
                    class="w-4 h-4 text-[#E65C4F] border-gray-300 rounded focus:ring-[#E65C4F]"
                    {{ request('is_volunteer_event') ? 'checked' : '' }}>
                <label for="is_volunteer_event" class="text-sm text-foreground">Volontariato</label>
            </div>
            </x-table-filters>
        </x-slot:filters>

        <x-slot:actions>
            <div class="flex justify-end w-full py-6 actions-btn">
                <x-crud-button type="add" class="me-12" href="{{ route('admin.partners.create') }}">
                </x-crud-button>
            </div>
        </x-slot:actions>
    </x-table-toolbar>

    <div class="px-8 my-8">
        <x-table-admin :columns="[
            'firstname' => 'Nome',
            'email' => 'Email',
            'birthday' => 'Data di Nascita',
            'contact_phone' => 'Recapito Telefonico',
            'status' => 'Stato',
        ]" :rows="$partners"     :actions="function($partner) {
        return view('components.table-actions', [
            'routes' => [
                'show' => route('admin.partners.show', $partner->id),
                'edit' => route('admin.partners.edit', $partner->id),
                'delete' => route('admin.partners.destroy', $partner->id),
            ],
        ])->render();
    }" />
    </div>
</x-admin-layout>

{{-- <div class="text-base font-semibold">
    {{ $partner->partnerInfo->name . ' ' . $partner->partnerInfo->lastname }}</div>


<a href="{{ route('admin.partners.edit', $partner->id) }}"
    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modifica Info</a>
<div x-data="{ open: false, status: 'attivo' }" class="inline">
    <!-- Bottone per aprire il modal -->
    <button @click="open = true" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
        Modifica Stato
    </button>

    <x-confirmation-modal>

        <x-slot name="header">
            Modifica Stato Partner
        </x-slot>

        <x-slot name="body">
            <div class="flex items-center gap-5 px-8">
                <h3>Stato: </h3>
                <x-select-admin class="h-8" :options="$statuses" :selected="$partner->is_active"></x-select-admin>
            </div>

        </x-slot>

        <x-slot name="footer">

            <x-crud-button label="Annulla" type="delete" @click="open = false"
                class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800">
            </x-crud-button>

            <x-crud-button type="confirm" @click="open = false; $dispatch('status-updated', { status })"
                class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                Salva
            </x-crud-button>

        </x-slot>

    </x-confirmation-modal>
</div> --}}


