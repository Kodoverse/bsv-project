@extends('layouts.mystyle')
@section('content')
    <x-app-layout>
        <div class="p-6">
            <div class="flex gap-6">
                <div class="flex flex-wrap w-1/2 gap-4 mx-auto justify-content-center">
                    <div
                        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <img alt="">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $event->title }}
                        </h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ $event->description }}</p>
                        <div class="py-1 text-white"><span class="mx-2">Data inizio:</span>{{ $event->starts_at }}</div>
                        <div class="py-1 text-white"><span class="mx-2">Data fine:</span>{{ $event->ends_at }}</div>
                        <div class="py-1 text-white"><span class="mx-2">Numero Massimo
                                Partecipanti:</span>{{ $event->max_participants }}</div>
                        <h3 class="text-white">Categoria principale:
                            {{ $event->category->parent ? $event->category->parent->name : '-' }}
                        </h3>

                        <h4 class="text-white">Sottocategoria:
                            {{ $event->category->name }}
                        </h4>
                    </div>
                </div>
                <div class="registration-table">
                    @foreach ($event->registrations as $registration)
                        <div class="text-white">{{ $registration->user }}</div>
                    @endforeach
                </div>
                <a href="{{ route('events.edit', $event->id) }}">
                    <button
                        class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Edit</button>
                </a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                </form>
            </div>


        </div>


    </x-app-layout>
@endsection
