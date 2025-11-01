<x-admin-layout
    title="Eventi"
    subtitle="Gestione eventi"
    :breadcrumbs="[
        'Dashboard' => route('admin.dashboard'),
        'Eventi' => null
    ]"
>
<x-table-toolbar>
    <x-slot:filters>
        <x-table-filters searchPlaceholder="Cerca evento...">
            <x-select-admin />
        </x-table-filters>
    </x-slot:filters>

    <x-slot:actions>
        <div class="flex justify-end w-full py-6 actions-btn">
    <x-crud-button type="add" class="me-12" href="{{ route('admin.events.create') }}">
    </x-crud-button>
</div>
    </x-slot:actions>
</x-table-toolbar>

<div class="px-8 my-8">
<x-table-admin 
    :columns="[
        'title' => 'Titolo',
        'description' => 'Descrizione',
        'is_volunteer_event' => 'Evento Volontariato',
        'max_participants' => 'N° Max Partecipanti' 
    ]"
    :rows="$events"
    :actions="fn($event) => view('components.table-actions', ['event' => $event])"
/>
</div>
</x-admin-layout>

