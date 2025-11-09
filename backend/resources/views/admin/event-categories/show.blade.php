<x-admin-layout :title="$eventCategory->name" :subtitle="$eventCategory->parent" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard'),
    'Categorie Eventi' => null,
]">
    <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-[1500px] md:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-end gap-4 mb-8">
                <a href="{{ route('admin.event-categories.edit', $eventCategory->id) }}">
                    <x-crud-button type="edit" />
                </a>

                <a href="{{ route('admin.event-categories.create', ['parent_id' => $eventCategory->id]) }}">
                    <x-crud-button type="add"></x-crud-button></a>

                <x-confirmation-modal>
                    {{-- Trigger --}}
                    <x-slot:trigger>
                        <x-crud-button type="delete" />
                    </x-slot:trigger>

                    {{-- Header --}}
                    <x-slot:header>
                        @if ($eventCategory->parent_id === null)
                            <h2 class="text-lg font-semibold text-foreground">Elimina categoria</h2>
                        @else
                            <h2 class="text-lg font-semibold text-foreground">Elimina sottocategoria</h2>
                        @endif

                    </x-slot:header>

                    {{-- Body --}}
                    <x-slot:body>
                        @if ($eventCategory->parent_id === null)
                            <p class="text-sm text-muted-foreground">
                                Sei sicuro di voler eliminare questa categoria? L'eliminazione comportera' la <span
                                    class="font-bold">cancellazione</span> di tutte le sottocategorie associate
                            </p>
                        @else
                            <p class="text-sm text-muted-foreground">
                                Sei sicuro di voler eliminare questa sottocategoria?
                            </p>
                        @endif

                    </x-slot:body>

                    {{-- Footer --}}
                    <x-slot:footer>
                        <x-crud-button type="delete" label="Annulla" @click="open = false" />
                        <form method="POST" action="{{ route('admin.event-categories.destroy', $eventCategory->id) }}">
                            @csrf
                            @method('DELETE')
                            <x-crud-button type="confirm" label="Conferma" />
                        </form>
                    </x-slot:footer>
                </x-confirmation-modal>
            </div>

            @if ($eventCategory->parent_id === null)
                <h2 class="mb-6 text-xl font-semibold text-foreground">Sottocategorie</h2>

                @if ($eventCategory->children->isEmpty())
                    <p class="text-muted-foreground">Nessuna sottocategoria presente.</p>
                @else
                    <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($eventCategory->children as $child)
                            <x-card-admin :title="$child->name" :href="route('admin.event-categories.subcategory.show', [
                                'parent' => $eventCategory->id,
                                'child' => $child->id,
                            ])" :isSubcategory="true" />
                        @endforeach
                    </div>
                @endif
            @else
                <h2 class="mb-4 text-xl font-semibold text-foreground">Eventi associati</h2>
                @if ($events->count())
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($events as $event)
                            <x-card-admin :title="$event->title" :image="$event->image_url ?? null" :href="route('admin.events.show', $event->id)" />
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $events->links() }}</div>
                @else
                    <p class="text-muted-foreground">Nessun evento associato a questa sottocategoria.</p>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
