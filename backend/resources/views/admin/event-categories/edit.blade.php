    <x-admin-layout :title="$eventCategory->parent_id ? 'Modifica Sottocategoria ' . $eventCategory->name : 'Modifica Categoria ' . $eventCategory->name" :breadcrumbs="[
        'Dashboard' => route('admin.dashboard'),
        'Categorie Eventi' => route('admin.event-categories.index'),
        '{{ $event->title }}' => route('admin.event-categories.show', $eventCategory->id),
    ]">
        <div class="flex flex-col items-center w-full py-10 overflow-hidden">
            <div class="w-full max-w-5xl md:px-8">
                <x-form-admin :action="route('admin.event-categories.update', $eventCategory->id)" method="PUT" :submit-label="$eventCategory->parent_id ? 'Modifica Sottocategoria' : 'Modifica Categoria'"
                    enctype="multipart/form-data">
                    <x-form-section>
                        <x-input-admin id="name" :label="$eventCategory->parent_id ? 'Nome Sottocategoria' : 'Nome Categoria'" type="text" name="name"
                            :value="old('name', $eventCategory->name)" />
                        <x-input-color id="color" name="color" label="Colore" :value="old('color', $eventCategory->color)" />
                    </x-form-section>
                    <div class="flex flex-row justify-center gap-6">
                        <x-crud-button type="confirm" label="Modifica" />
                        <x-crud-button type="delete" label="Annulla"
                            href="{{ route('admin.event-categories.show', $eventCategory->id) }}" />
                    </div>
                </x-form-admin>
            </div>
        </div>
    </x-admin-layout>
