    <x-admin-layout title="Modifca Categoria Evento {{ $eventCategory->name }}">
        <div class="flex flex-col w-full px-12 overflow-hidden">


            <div>
                <x-form-admin :action="route('admin.event-categories.update', $eventCategory->id)" method="PUT" title="Modifica Categoria Evento" submit-label="Modifica Categoria"
                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-5">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                        <input type="text" id="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') is-invalid 
                                  @enderror" value="{{ old('name') ?? $eventCategory->name }}"
                                            name="name">
                                        @error('name')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>



                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <x-crud-button type="confirm">Create</x-crud-button>
                                    <a href="{{ route('admin.event-categories.index') }}"></a>

                                </x-form-admin>
                                <a href="{{ route('admin.event-categories.show', $eventCategory->id) }}">
                                <x-crud-button type="delete" label="Annulla"></x-crud-button>
                                </a>

                            </div>
                        </div>


    </x-admin-layout>
