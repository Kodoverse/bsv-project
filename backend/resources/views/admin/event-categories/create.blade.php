<x-admin-layout :title="$parent ? 'Nuova sottocategoria' : 'Nuova categoria'">
    <x-form-admin 
        :action="route('admin.event-categories.store')" 
        method="POST"
        submit-label="{{ $parent ? 'Crea sottocategoria' : 'Crea categoria' }}"
        enctype="multipart/form-data">

        <x-form-section>
            <x-input-admin id="title" label="Nome {{ $parent ? 'sottocategoria' : 'categoria' }}" type="text" name="title" />
            <x-input-color id="primary_color" name="primary_color" label="Colore" />

            {{-- Mostra select solo se è una sottocategoria --}}
            @if ($parent)
                <x-select-admin
                    id="parent_id"
                    name="parent_id"
                    label="Categoria di appartenenza"
                    :options="$categories"
                    :value="$parent->id"
                    :disabled="true"
                />
            @endif
        </x-form-section>

    </x-form-admin>
</x-admin-layout>
