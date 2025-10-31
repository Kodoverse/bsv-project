    <x-admin-layout title="Aggiungi un nuovo partner">
        <div class="flex flex-col items-center w-full overflow-hidden">
            <div class="w-full py-12">
                <div class="w-full">
                    <div>
                        <div class="flex justify-between">
                        </div>

                        <div class="w-full px-6">

                            <div class="flex justify-start">

                                <form action="{{ route('admin.partners.store') }}"
                                    method="POST" class="w-full max-w-xl">
                                    @csrf
                                    <h3 class="mb-5 text-red-500">Partner Info</h3>
                                    <div class="mb-5">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome
                                            Partner</label>
                                        <input type="text" id="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') is-invalid 
                                  @enderror"
                                            name="name">
                                        @error('name')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="lastname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cognome
                                            Partner</label>
                                        <input type="text" id="lastname"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('lastname') is-invalid 
                                  @enderror"
                                            name="lastname">
                                        @error('lastname')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Indrizzo
                                            Email Partner</label>
                                        <input type="email" id="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') is-invalid 
                                  @enderror"
                                            name="email">
                                        @error('email')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <h3 class="mb-5 text-red-500">Info Attivita'</h3>
                                    <div class="mb-5">
                                        <label for="business_name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome
                                            Attivita'</label>
                                        <input type="text" id="business_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('business_name') is-invalid 
                                  @enderror"
                                            name="business_name">
                                        @error('business_name')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="business_category"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Categoria
                                        </label>
                                        <select id="business_category" name="business_category_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                                                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                                                  dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('business_category') is-invalid @enderror">
                                            <option value="">Seleziona una categoria</option>
                                            @foreach ($busCategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('business_category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('business_category')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-5">
                                        <label for="business_address"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Indirizzo Attivita'
                                        </label>
                                        <input type="text" id="business_address" name="business_address"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
               block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
               dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('business_address') is-invalid @enderror"
                                            accept="business_address/*">
                                        @error('business_address')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="business_description"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Descrizione Attivita'
                                        </label>
                                        <input type="text" id="business_description" name="business_description"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
               block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
               dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('business_description') is-invalid @enderror">
                                        @error('business_description')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="contact_phone"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Numero di Telefono
                                        </label>
                                        <input type="text" id="contact_phone" name="contact_phone"
                                            value="{{ old('contact_phone') }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('contact_phone') is-invalid @enderror"
                                            min="1">
                                        @error('contact_phone')
                                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="business_email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Indrizzo
                                            Email Attivita'</label>
                                        <input type="email" id="business_email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('business_email') is-invalid 
                                  @enderror"
                                            name="business_email">
                                        @error('business_email')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label class="inline-flex items-center" id="is_active">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" name="is_active" value="1"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600">
                                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Attiva
                                                Partner</span>
                                        </label>
                                    </div>

                                    @if ($errors->any())
                                        <div class='text-red-700'>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                     <x-crud-button type="confirm" :href="route('admin.events.index')" />

                                </form>

                            </div>
                        </div>


    </x-admin-layout>

