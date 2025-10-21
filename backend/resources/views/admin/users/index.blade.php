@extends('layouts.admin')

@section('content')
<x-app-layout>
    <x-page-header
    title="Gestione Utenti"/>

    <div x-data="{ activeTab: 'users' }" class="w-full mt-3">
        <!-- Tabs Navigation -->
        <div class="mb-6 text-center text-white">
            <ul class="flex justify-center gap-10">
                <li>
                    <button
                        @click="activeTab = 'users'"
                        :class="activeTab === 'users' ? 'bg-red-700' : 'bg-red-500/70 hover:bg-red-600/80'"
                        class="px-4 py-2 transition-colors duration-200 rounded-md"
                    >
                        Utenti
                    </button>
                </li>
                <li>
                    <button
                        @click="activeTab = 'partners'"
                        :class="activeTab === 'partners' ? 'bg-red-700' : 'bg-red-500/70 hover:bg-red-600/80'"
                        class="px-4 py-2 transition-colors duration-200 rounded-md"
                    >
                        Partner
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab: Utenti -->
        <div
            x-show="activeTab === 'users'"
            x-cloak
            class="w-full"
        >
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
                            <th class="px-6 py-3">Registrazioni Eventi</th>
                            <th class="px-6 py-3">Partecipazioni Eventi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->user_role }}</td>
                                <td class="px-6 py-4">{{ $user->created_at }}</td>
                                <td class="px-6 py-4">{{ $user->total_registrations }}</td>
                                <td class="px-6 py-4">{{ $user->attended_count }}</td>
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

        <!-- Tab: Partner -->
        <div
            x-show="activeTab === 'partners'"
            x-cloak
            class="w-full"
        >
            <div class="relative w-4/5 mx-auto overflow-x-auto shadow-md sm:rounded-lg fade">
                <div class="py-5 text-center text-white">
                    <h3 class="text-xl">Partner</h3>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nome</th>
                            <th class="px-6 py-3">Cognome</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Ruolo</th>
                            <th class="px-6 py-3">Data Registrazione</th>
                            <th class="px-6 py-3">Numero di Contatto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $partner)
                            <tr class="border-b odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $partner->partnerInfo->name }}</td>
                                <td class="px-6 py-4">{{ $partner->partnerInfo->lastname }}</td>
                                <td class="px-6 py-4">{{ $partner->email }}</td>
                                <td class="px-6 py-4">{{ $partner->user_role }}</td>
                                <td class="px-6 py-4">{{ $partner->created_at }}</td>
                                <td class="px-6 py-4">{{ $partner->partnerInfo->contact_phone }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.show', $partner->id) }}"
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
</x-app-layout>
@endsection
