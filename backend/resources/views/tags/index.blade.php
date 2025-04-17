@extends('layouts.mystyle')
@section('content')

<div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
    <table class="text-sm w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
               
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$tag->name}}
                </th>
                <td class="px-6 py-4">
                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                <button>Delete</button>
                </form>
                <a href="{{ route('tags.edit', $tag->id) }}" target="_blank" rel="noopener noreferrer">
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                        Edit
                    </button>
                </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('tags.create') }}" target="_blank" rel="noopener noreferrer">
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-indigo-700">
                        Add Tag
                    </button>
     </a>
</div>
@endsection