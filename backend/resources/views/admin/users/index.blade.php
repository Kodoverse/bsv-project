@extends('layouts.mystyle')
@section('content')
    <x-app-layout>
        <div class="w-5/6 mx-auto">
        <h1 class="my-6 text-4xl text-white"> Gestione Utenti</h1>
</div>
        <div class="">
            <div class="py-5 text-center text-white">
                <h3 class="text-xl">Utenti</h3>
            </div>
            <div class="relative w-4/5 mx-auto overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ruolo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Data Registrazione
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Registrazioni Eventi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Partecipazioni Eventi
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr
                                class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->user_role }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->created_at }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->total_registrations }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->attended_count }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Visualizza</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

                <div class="mt-6">
            <div class="py-5 text-center text-white">
                <h3 class="text-xl">Partner</h3>
            </div>
            <div class="relative w-4/5 mx-auto overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>       <th scope="col" class="px-6 py-3">
                               Nome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cognome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ruolo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Data Registrazione
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Numero di Contatto
                            </th>
                     
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $partner)
                            <tr
                                class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{ $partner->partnerInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $partner->partnerInfo->lastname }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $partner->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $partner->user_role }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $partner->created_at }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $partner->partnerInfo->contact_phone }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.show', $partner->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Visualizza</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-app-layout>
@endsection
