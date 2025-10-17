@extends('layouts.admin')
@section('content')

<x-app-layout>


    <div class="flex flex-col items-center w-full overflow-hidden">
    
        <div class="w-full py-12">
            <div class="w-full">
                <div>
                    <div class="flex justify-between">
                        <div v-if="user" class="flex flex-col gap-5 py-6 ps-6">
                            <h1 class="text-3xl tracking-wide uppercase">My Articles</h1>
                        </div>
                    </div>
    
                    <div class="w-full px-6">
                        <div class="grid mx-auto">
                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="text-gray-900 dark:text-gray-100">
                                    <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
                                        
                                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($tags as $tag)
                                                <tr class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                                   
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$tag->name}}
                                                    </th>
                                                    <td class="flex gap-6 px-6 py-4">
                                                        <a href="{{ route('tags.edit', $tag->id) }}" rel="noopener noreferrer">
                                                            <button class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                                                Edit
                                                            </button>
                                                        </a>
                                                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        <button class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
            
                                        <a href="{{ route('tags.create') }}" rel="noopener noreferrer">
                                            <button class="px-4 py-2 m-5 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                                Add Tag
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</x-app-layout>
@endsection
