    <x-admin-layout title="I partner">
        <a href="{{ route('admin.partners.create') }}">
            <button>Aggiungi Partner</button>
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
                class="flex flex-wrap items-center justify-between pb-4 space-y-4 bg-white flex-column md:flex-row md:space-y-0 dark:bg-gray-900">
                <div>
                    <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">
                        <span class="sr-only">Action button</span>
                        Action
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownAction"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate
                                    account</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                User</a>
                        </div>
                    </div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-users"
                        class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for users">
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Data di Nascita
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Numero di Contatto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stato
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Attivita' collegate
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Azione
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partners as $partner)
                        <tr
                            class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg"
                                    alt="Jese image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        {{ $partner->partnerInfo->name . ' ' . $partner->partnerInfo->lastname }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div>{{ $partner->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $partner->partnerInfo->birthday }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $partner->partnerInfo->contact_phone }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-2.5 w-2.5 rounded-full me-2 {{ $partner->partnerInfo->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                                    </div> {{ $partner->partnerInfo->is_active ? 'Attivo' : 'Non Attivo' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                2
                            </td>
                            <td class="flex gap-2 px-6 py-4">

                                <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modifica Info</a>
                                <div x-data="{ open: false, status: 'attivo' }" class="inline">
                                    <!-- Bottone per aprire il modal -->
                                    <button @click="open = true" type="button"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Modifica Stato
                                    </button>

                                    <x-confirmation-modal>
                                        
                                        <x-slot name="header">
                                            Modifica Stato Partner
                                        </x-slot>
                                        
                                        <x-slot name="body">
                                                <div class="flex items-center gap-5 px-8">
                                                <h3>Stato: </h3>
                                                <x-select-admin class="h-8" :options="$statuses" :selected="$partner->is_active"></x-select-admin>
                                                </div>

                                        </x-slot>
                                        
                                        <x-slot name="footer">
                                            
                                            <x-crud-button label="Annulla" type="delete" @click="open = false"
                                                class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800">
                                            </x-crud-button>

                                            <x-crud-button type="confirm"
                                                @click="open = false; $dispatch('status-updated', { status })"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                                Salva
                                            </x-crud-button>
                                        
                                        </x-slot>

                                    </x-confirmation-modal>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </x-admin-layout>