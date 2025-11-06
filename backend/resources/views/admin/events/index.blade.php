<x-admin-layout title="Eventi" subtitle="Gestione eventi" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Eventi' => null,
]">
      <div class="flex flex-col items-center w-full py-10 overflow-hidden">
          <div class="w-full max-w-[1920px] md:px-8">

<x-widget-group class="gap-16 mb-12" :widgets="$widgets" />
<x-table-toolbar>
    <x-slot:filters>
        <x-table-filters searchPlaceholder="Cerca evento...">
     {{-- Filtro stato --}}
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

</x-table-toolbar>

    <div class="flex justify-end w-full px-8 py-6 actions-btn">
        <x-crud-button type="add" href="{{ route('admin.events.create') }}" />
    </div>
    <div class="px-8 my-8">
        <x-table-admin :columns="[
            'title' => 'Titolo',
            'description' => 'Descrizione',
            'is_volunteer_event' => 'Evento Volontariato',
            'max_participants' => 'N° Max Partecipanti',
        ]" :rows="$events" :actions="function ($event) {
            return view('components.table-actions', [
                'routes' => [
                    'show' => route('admin.events.show', $event->id),
                    'edit' => route('admin.events.edit', $event->id),
                    'delete' => route('admin.events.destroy', $event->id),
                ],
            ])->render();
        }" />
    </div>
    </div>
    </div>
</x-admin-layout>
