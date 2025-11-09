<x-admin-layout title="{{ $event->title }}" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Eventi' => route('admin.events.index'),
]">

    <x-show-layout
        :image="$event->image_url"
        :fallback="asset('images/fallback.png')">
        <x-slot:actions>
            @if($event->starts_at > date('') && $event->ends_at > date('Y-m-d h:i:s'))
                <a href="{{ route('admin.events.edit', $event->id) }}" class="lg:hidden">
                <x-crud-button label="QR Scan" />
            </a>
            @endif
            <a href="{{ route('admin.events.edit', $event->id) }}">
                <x-crud-button type="edit" />
            </a>
                <x-confirmation-modal>
                    {{-- Trigger --}}
                    <x-slot:trigger>
                        <x-crud-button type="delete" />
                    </x-slot:trigger>

                    {{-- Header --}}
                    <x-slot:header>
                        <h2 class="text-lg font-semibold text-foreground">Elimina evento</h2>
                    </x-slot:header>

                    {{-- Body --}}
                    <x-slot:body>
                        <p class="text-sm text-muted-foreground">
                            Sei sicuro di voler eliminare questo evento? L'operazione non è reversibile.
                        </p>
                    </x-slot:body>

                    {{-- Footer --}}
                    <x-slot:footer>
                        <x-crud-button type="delete" label="Annulla" @click="open = false" />
                        <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}">
                            @csrf
                            @method('DELETE')
                            <x-crud-button type="confirm" label="Conferma" />
                        </form>
                    </x-slot:footer>
                </x-confirmation-modal>
        </x-slot:actions>

        <div class="space-y-2 text-[15px]">
            <div><strong class="text-[#E65C4F]">Descrizione:</strong> {{ $event->description }}</div>
            <div><strong class="text-[#E65C4F]">Categoria:</strong> {{ $event->parent_category_name ?? '—' }}</div>
            <div><strong class="text-[#E65C4F]">Sottocategoria:</strong> {{ $event->category->name }}</div>
            <div><strong class="text-[#E65C4F]">Num Max Partecipanti:</strong> {{ $event->max_participants }}</div>
            <div><strong class="text-[#E65C4F]">Evento Volontariato:</strong> {{ $event->is_volunteer_event_label }}</div>
            <div><strong class="text-[#E65C4F]">Punti Ottenibili:</strong> {{ $event->volunteer_points }}</div>
            <div><strong class="text-[#E65C4F]">Data Inizio:</strong> {{ $event->starts_at }}</div>
            <div><strong class="text-[#E65C4F]">Data Fine:</strong> {{ $event->ends_at }}</div>
            <div><strong class="text-[#E65C4F]">Stato Evento:</strong> {{ $event->status }}</div>
        </div>
        <x-slot:bottom>
            
            <div class="py-6"><h3 class="text-3xl font-bold">Utenti registrati all'evento</h3></div>
        <x-table-admin 
            :columns="[
            'email' => 'Utente', 
            'status' => 'Stato',
            'registered_at' => 'Data Registrazione',
            'notes' => 'Note',
            ]"
            :rows="$event->registrations"
        />
        </x-slot:bottom>
    </x-show-layout>

</x-admin-layout>

