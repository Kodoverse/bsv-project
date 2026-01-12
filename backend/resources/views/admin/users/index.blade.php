<x-admin-layout title="Gestione Utenti" :breadcrumbs="[
    'Dashboard' => route('admin.dashboard')
]">
 <div class="flex flex-col items-center w-full py-10 overflow-hidden">
        <div class="w-full max-w-[1500px] md:px-8">
            <x-table-toolbar>
                 <x-slot:filters>
        <x-table-filters searchPlaceholder="Cerca utente...">
     {{-- Filtro stato --}}
            <x-select-admin
                id="user_role"
                name="user_role"
                :options="[
                    (object)['id' => 'admin', 'name' => ' Admin'],
                    (object)['id' => 'editor', 'name' => 'Editor'],
                    (object)['id' => 'librarian', 'name' => 'Gestore Biblioteca'],
                    (object)['id' => 'sub-admin', 'name' => 'Sub-Admin']
                ]"
                :value="request('user_role')"
                placeholder="Tutti i ruoli"
            />
        </x-table-filters>
    </x-slot:filters>
    </x-table-toolbar>
            <div class="flex items-center justify-end gap-4 mb-8">

                <a href="{{ route('admin.event-categories.create') }}">
                    <x-crud-button type="add"></x-crud-button></a>
            </div>
    
            <div class="relative w-4/5 mx-auto overflow-x-auto shadow-md sm:rounded-lg">
                <div class="py-5 text-center text-white">
                    <h3 class="text-xl">Utenti</h3>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Ruolo</th>
                            <th class="px-6 py-3">Data Registrazione</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->user_role }}</td>
                                <td class="px-6 py-4">{{ $user->created_at }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Visualizza
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
