<x-app-layout title="{{ $eventCategory->name }}">
        <div class="p-6">
            <div class="flex gap-6">
             <a href="{{ route('admin.event-categories.edit', $eventCategory->id) }}">
                    <x-crud-button
                        type="edit"></x-crud-button>
                </a>
                <form action="{{ route('admin.event-categories.destroy', $eventCategory->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-crud-button type="delete"></x-crud-button>
                </form>
            </div>


        </div>


    </x-app-layout>
