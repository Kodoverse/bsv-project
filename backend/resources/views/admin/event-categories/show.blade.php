@extends('layouts.admin')
@section('content')
    <x-app-layout>
        <div class="p-6">
            <div class="flex gap-6">
             <a href="{{ route('admin.event-categories.edit', $eventCategory->id) }}">
                    <button
                        class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Edit</button>
                </a>
                <form action="{{ route('admin.event-categories.destroy', $eventCategory->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                </form>
            </div>


        </div>


    </x-app-layout>
@endsection