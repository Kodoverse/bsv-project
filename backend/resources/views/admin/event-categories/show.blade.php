<x-app-layout title="{{ $eventCategory->name }}">
        <div class="p-6">
            <div class="flex gap-6">
                <a href="{{ route('admin.event-categories.create', ['parent_id' => $eventCategory->id]) }}">
                    <x-crud-button type="add"></x-crud-button>
                
</a>
             <a href="{{ route('admin.event-categories.edit', $eventCategory->id) }}">
                    <x-crud-button
                        type="edit"></x-crud-button>
                </a>
            <x-confirmation-modal 
                :confirmAction="route('admin.event-categories.destroy', $eventCategory->id)"
                title="Elimina categoria"
                message="Questa azione è irreversibile. Vuoi davvero eliminarla?"
            >
                <x-crud-button type="delete" data-confirm />
            </x-confirmation-modal>
            </div>


        </div>


    </x-app-layout>
