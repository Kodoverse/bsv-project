<x-admin-layout :title="$parent ? 'Nuova sottocategoria' : 'Nuova categoria'" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard')]">
        <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-[1500px] md:px-8">
    <x-form-admin 
        :action="route('admin.event-categories.store')" 
        method="POST"
        submit-label="{{ $parent ? 'Crea sottocategoria' : 'Crea categoria' }}"
        enctype="multipart/form-data">

        <x-form-section>
            <x-input-admin id="name" label="Nome {{ $parent ? 'sottocategoria' : 'categoria' }}" type="text" name="name" />
            <x-input-color id="color" name="color" label="Colore" />

            {{-- Mostra select solo se è una sottocategoria --}}
@if ($parent)
    {{-- Selezione bloccata (solo per mostrare la categoria madre) --}}
    <x-select-admin
        id="parent_id"
        name="parent_id"
        label="Categoria di appartenenza"
        :options="$categories"
        :value="$parent->id"
        :disabled="true"
    />

    {{-- Campo nascosto con il valore effettivo --}}
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
@endif
        </x-form-section>

                <div class="flex flex-row justify-center gap-6">
                    <x-crud-button type="confirm" label="Crea"/>
                    <x-crud-button type="delete" label="Annulla" href="{{ route('admin.events.index') }}" />
                </div>
    </x-form-admin>
</div>
</div>
</x-admin-layout>
