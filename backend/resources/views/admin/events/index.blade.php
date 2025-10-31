<x-admin-layout
    title="Eventi"
    subtitle="Gestione eventi"
    :breadcrumbs="[
        'Dashboard' => route('admin.dashboard'),
        'Eventi' => null
    ]"
>
<div class="flex justify-end w-full py-6 actions-btn">
    <x-crud-button type="add" class="me-12" href="{{ route('admin.events.create') }}">
    </x-crud-button>
</div>
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

