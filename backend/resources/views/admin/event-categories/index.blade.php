@extends('layouts.admin')

@section('content')

<x-app-layout>

    <div class="text-white">Index Categorie Eventi</div>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nome</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventCategories as $eventCategory)
                            <tr class="border-b odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $eventCategory->name }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.event-categories.show', $eventCategory->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Visualizza
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
</x-app-layout>

@endsection