@extends('layouts.admin')
@section('content')
    <x-app-layout>
        <x-page-header
    title="Eventi"
    icon="lucide-calendar"
/>
        <div class="flex flex-wrap w-1/2 gap-4 mx-auto justify-content-center">
            @foreach ($events as $event)
                <div
                    class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <img alt="">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $event->title }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ $event->description }}</p>
                    <p></p>
                    <div class="text-center">
                        <a href="{{ route('events.show', $event->id) }}"><button class="btn btn-primary">Visualizza
                                Dettagli</button></a>
                    </div>
                </div>
            @endforeach
        </div>
    </x-app-layout>
@endsection
