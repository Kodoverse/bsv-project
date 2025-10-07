@extends('layouts.mystyle')
@section('content')
    <x-app-layout>
        <div class="p-6">
            <div class="flex gap-6">
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
